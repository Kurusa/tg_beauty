<?php

namespace App\Commands;

use App\Models\Record;
use App\Services\RecordStatusService;
use App\Services\UserStatusService;

/**
 * Class MainMenu
 * @package App\Commands
 */
class MainMenu extends BaseCommand {

    /**
     * @param bool $par
     */
    function processCommand($par = false)
    {
        // delete possible undone record
        $filling_record = Record::where('chat_id', $this->user->chat_id)->where('status', RecordStatusService::FILLING)->first();
        if ($filling_record) {
            $filling_record->delete();
        }

        $this->user->status = UserStatusService::DONE;
        $this->user->save();

        $this->tg->sendMessageWithKeyboard($par ?: 'Каждый день, мы собираемся в студии AZ BEAUTY, чтобы делать тебе умопомрачительные маникюры, ресницы, брови, которыми хочется хвастаться перед всеми подружками и постить в сторис!
В этом боте Вы можете
записаться онлайн на свободные окошки к нам)
Никакого спама, только комфортный сервис.🙂

Мы общаемся с помощью кнопок. Они находятся внизу экрана👇⬇️', [
            ['Запись онлайн 😊'], ['Прайс ❤️'], ['Отменить запись 😭'], ['Свяжитесь с нами 📲']
        ]);
    }

}