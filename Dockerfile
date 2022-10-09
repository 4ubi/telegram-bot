FROM php:8.1.0-fpm-alpine3.15 as php-fpm

ARG HOST_UID
RUN if [ ! -z "${HOST_UID}" ]; then \
        deluser www-data \
        && addgroup www-data \
        && adduser -u "${HOST_UID}" -G www-data -H -s /bin/sh -D www-data; \
    fi

ARG WITH_XDEBUG=false
#install required modules
RUN apk update \
    && apk add --no-cache --virtual .php-deps $PHPIZE_DEPS \
    && apk add --update --no-cache \
        bash \
        libzip-dev \
        libpq-dev \
        icu-dev \
    && docker-php-ext-install \
        zip \
        intl \
        bcmath \
        sockets \
        opcache \
        pdo_pgsql \
        pgsql \
    && if [ "${WITH_XDEBUG}" = "true" ] ; then \
          pecl install xdebug; \
          docker-php-ext-enable xdebug; \
          chown www-data:www-data -R /usr/local/etc/php/conf.d; \
       fi \
    && apk del .php-deps \
    && rm -rf /tmp/* /var/cache/apk/*

COPY .docker/fpm/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY .docker/fpm/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY .docker/fpm/www.conf /usr/local/etc/php-fpm.d/www.conf

RUN chown www-data:www-data /var/www

USER www-data
WORKDIR /var/www

#install dependencies
FROM composer:2 as vendor

COPY composer.json composer.json
COPY composer.lock composer.lock

RUN composer install \
    --ignore-platform-reqs \
    --no-autoloader \
    --no-dev \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

COPY --chown=www-data:www-data . ./
RUN composer dump-autoload --no-scripts --no-dev --optimize

# Build application.
FROM php-fpm

COPY --chown=www-data:www-data . /var/www/
COPY --from=vendor --chown=www-data:www-data /app/vendor/ /var/www/vendor/

ARG TAG_VERSION
ARG COMMIT_SHA

ENV PHP_OPCACHE=1
ENV TAG_VERSION=$TAG_VERSION
ENV COMMIT_SHA=$COMMIT_SHA

LABEL org.label-schema.name="telegrambot-backend:php:8.1-fpm-alpine" \
      org.label-schema.vendor="4ubaka" \
      org.label-schema.version="${TAG_VERSION}" \
      org.label-schema.vcs-ref="${COMMIT_SHA}"

