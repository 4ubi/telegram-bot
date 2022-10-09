<?php

namespace App\Bot\Telegram\Enum;

enum BotScenarioCommandsEnum: string
{
    case START = '/start';
    case USER_READY = 'Готов!';
    case USER_WANT_FINISHED = 'Завершить';
    case USER_WANT_GET_JOY = 'Хочу порадоваться🤗';
    case USER_GET_JOY_RETURN = 'Хочу порадоваться еще🤗';
    case USER_WANT_SEND_JOY = 'Хочу порадовать🙃';
    case USER_WANT_FINISHED_SEND_JOY = 'Завершить радовать';
    case USER_SEND_FILE = 'send_file';
}
