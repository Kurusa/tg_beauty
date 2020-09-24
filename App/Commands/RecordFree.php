<?php

namespace App\Commands;

use App\Models\Record;
use App\Services\RecordStatusService;
use App\TgHelpers\GoogleClient;

class RecordFree extends BaseCommand {

    function processCommand($par = false)
    {
        $service = [
            'Наращивание ресниц',
            'Маникюр',
            'Педикюр',
            'Микроблейдинг бровей',
            'Коррекция/ окрашивание бровей',
            'Макияж'
        ];
        $time = [
            '150', '120', '120', '180', '40', '120'
        ];
        $filling_record = Record::where('chat_id', $this->user->chat_id)->where('status', RecordStatusService::FILLING)->first();
        $google = new GoogleClient();
        $end_time = date('c', strtotime($this->parser::getByKey('add_id') . '+ ' . $time[$filling_record->service] . ' minutes'));
        $google->create($service[$filling_record->service] . ' ' . $this->parser::getByKey('add_id') . ' ' . $filling_record->user_name . ' ' . $filling_record->phone,
            $this->parser::getByKey('add_id'), $end_time);

        foreach (explode(',', env('ADMIN_LIST')) as $admin) {
            $this->tg->sendMessage($service[$filling_record->service] . ' ' . $this->parser::getByKey('add_id') . ' ' . $filling_record->user_name . ' ' . $filling_record->phone, $admin);
        }

        $this->triggerCommand(MainMenu::class, 'Спасибо! Вы успешно записаны на услугу ' . $service[$filling_record->service] . ' ' . $this->parser::getByKey('add_id') . '
Пожалуйста, если Вы не сможете прийти в назначенное время перенесите запись )
До скорой встречи!');

    }

}