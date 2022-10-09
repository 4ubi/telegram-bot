## What is it?
# Web bot for telegrams "Good news"
### This service for a telegram bot with a ready-made action script.Users of this bot can receive good news in the form of video recordings, and also share their news.

## Installing

#### 1. Cloning repository:
```
 git clone git@github.com:4ubi/telegram-bot.git
```

#### 2. Go to cloning repository telegram-bot

#### 3. Create bot in telegram.
```
 see: https://core.telegram.org/api#bot-api
```

#### 4. Open docker-compose file and enter your telegram token in env(TELEGRAM_TOKEN) in backend service:
```
        environment:
      - TELEGRAM_TOKEN=${TELEGRAM_TOKEN-your token}
```
#### 5. Start building docker container with docker-compose:
```
    docker-compose up
```  
#### 6. Use telegram API method to specify a URL and receive incoming updates via an outgoing webhook.
```
  https://core.telegram.org/bots/api#setwebhook
```


## Author: 
### Alexandr Nomokonov
#### email: nomokon2012@gmail.com