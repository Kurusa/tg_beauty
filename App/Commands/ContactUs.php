<?php

namespace App\Commands;

class ContactUs extends BaseCommand {

    function processCommand($par = false)
    {
        $this->tg->sendMessage('Мы ждём Вашего звонка!');
        $this->tg->sendContact(' +38(097) 757 69 67', 'AZ BEAUTY');
    }

}