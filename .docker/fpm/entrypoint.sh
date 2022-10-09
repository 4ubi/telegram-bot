#!/bin/sh

if [[ "true" != "${XDEBUG_ENABLED}" ]]; then
  echo "Disabled xdebug";
  rm -rf /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini;
fi

php bin/console d:m:m -n -vv

php-fpm
