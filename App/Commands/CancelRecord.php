<?php

namespace App\Commands;

class CancelRecord extends BaseCommand {

    function processCommand($par = false)
    {
        $this->tg->sendMessage('Нам очень жаль, что Вам пришлось отменить запись😭 Предупредите об этом администратора!');
        $this->tg->sendContact(' +38(097) 757 69 67', 'AZ BEAUTY');
    }

}