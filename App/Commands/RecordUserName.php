<?php

namespace App\Commands;

use App\Models\Record;
use App\Services\RecordStatusService;
use App\Services\UserStatusService;

class RecordUserName extends BaseCommand {

    function processCommand($par = false)
    {
        if ($this->user->status == UserStatusService::USER_NAME) {
            Record::where('chat_id', $this->user->chat_id)->where('status', RecordStatusService::FILLING)->update([
                'user_name' => $this->parser::getMessage()
            ]);
            $this->triggerCommand(RecordPhone::class);
        } else {
            $this->user->status = UserStatusService::USER_NAME;
            $this->user->save();

            $this->tg->sendMessageWithKeyboard('Укажите имя для записи', [['отменить']]);
        }
    }

}