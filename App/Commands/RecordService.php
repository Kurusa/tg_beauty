<?php

namespace App\Commands;

use App\Models\Record;
use App\TgHelpers\TelegramKeyboard;

class RecordService extends BaseCommand {

    function processCommand($par = false)
    {
        if ($this->parser::getByKey('a') == 'record_price') {
            Record::create([
                'chat_id' => $this->user->chat_id,
                'service' => $this->parser::getByKey('id')
            ]);
            $this->tg->deleteMessage($this->parser::getMsgId());
            $this->triggerCommand(RecordUserName::class);
        } else {
            TelegramKeyboard::addButton('Наращивание ресниц', ['a' => 'record_price', 'id' => '0']);
            TelegramKeyboard::addButton('Маникюр', ['a' => 'record_price', 'id' => '1']);
            TelegramKeyboard::addButton('Педикюр', ['a' => 'record_price', 'id' => '2']);
            TelegramKeyboard::addButton('Микроблейдинг бровей', ['a' => 'record_price', 'id' => '3']);
            TelegramKeyboard::addButton('Коррекция/ окрашивание бровей', ['a' => 'record_price', 'id' => '4']);
            TelegramKeyboard::addButton('Макияж', ['a' => 'record_price', 'id' => '5']);

            $this->tg->sendMessageWithInlineKeyboard('Выберите услугу', TelegramKeyboard::get());

        }
    }

}