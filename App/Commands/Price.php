<?php

namespace App\Commands;

use App\TgHelpers\TelegramKeyboard;

class Price extends BaseCommand {

    function processCommand($par = false)
    {
        TelegramKeyboard::addButton('Наращивание ресниц', ['a' => 'price', 'id' => 'lash']);
        TelegramKeyboard::addButton('Ногтевой сервис', ['a' => 'price', 'id' => 'nails']);
        TelegramKeyboard::addButton('Брови', ['a' => 'price', 'id' => 'brows']);

        if ($this->parser::getByKey('a') == 'price') {
            switch ($this->parser::getByKey('id')) {
                case 'lash':
                    $text = 'nude -370 грн 
2d , 3d, 4d - 430грн 
Голивуд 500 грн';
                    break;
                case 'nails':
                    $text = 'Маникюр 330 грн
Педикюр 390 грн';
                    break;
                case 'brows':
                    $text = 'Микроблейдинг бровей 800 грн
Коррекция/ окрашивание бровей 200 грн
Макияж 350/450 грн';
                    break;
            }

            $this->tg->updateMessageKeyboard($this->parser::getMsgId(), $text, TelegramKeyboard::get());
        } else {
            $this->tg->sendMessageWithInlineKeyboard('Выберите услугу', TelegramKeyboard::get());
        }
    }

}