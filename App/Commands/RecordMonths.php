<?php

namespace App\Commands;

use App\Models\Record;
use App\Services\RecordStatusService;
use App\TgHelpers\GoogleClient;
use App\TgHelpers\TelegramKeyboard;
use Carbon\Carbon;

class RecordMonths extends BaseCommand {

    function processCommand($par = false)
    {
        if ($this->parser::getByKey('a') == 'month') {
            $google = new GoogleClient();
            $filling_record = Record::where('chat_id', $this->user->chat_id)->where('status', RecordStatusService::FILLING)->first();
            $time = [
                '150', '120', '120', '180', '40', '120'
            ];
            $free = $google->getRecords($this->parser::getByKey('s'), $this->parser::getByKey('e'), $time[$filling_record->service]);
            if ($free) {
                TelegramKeyboard::$list = $free;
                TelegramKeyboard::$button_title = 'time';
                TelegramKeyboard::$columns = 2;
                TelegramKeyboard::$action = 'time';
                TelegramKeyboard::$add_id = 'time';
                TelegramKeyboard::build();
                TelegramKeyboard::addButton('назад', ['a' => 'month_back']);
                $this->tg->updateMessageKeyboard($this->parser::getMsgId(), 'Выберите время', TelegramKeyboard::get());
            } else {
                $this->tg->sendMessage('Нет свободного места на этот день');
            }
        } else {
            $array = [];
            for ($i = 0; $i <= 30; $i++) {
                $array[] = [
                    'title' => Carbon::now()->addDays($i)->toDateString(),
                    'callback' => [
                        'a' => 'month',
                        's' => Carbon::now()->addDays($i)->startOfDay()->timestamp,
                        'e' => Carbon::now()->addDays($i)->endOfDay()->timestamp,
                    ]
                ];
            }
            TelegramKeyboard::$list = $array;
            TelegramKeyboard::$button_title = 'title';
            TelegramKeyboard::$callback_data = 'callback';
            TelegramKeyboard::$columns = 3;
            TelegramKeyboard::build();

            if ($this->parser::getByKey('a') == 'month_back') {
                $this->tg->updateMessageKeyboard($this->parser::getMsgId(), 'Выберите месяц', TelegramKeyboard::get());
            } else {
                $this->tg->sendMessageWithInlineKeyboard('Выберите месяц', TelegramKeyboard::get());
            }
        }
    }

}