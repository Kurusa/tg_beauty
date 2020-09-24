<?php
return [
    \App\Services\UserStatusService::USER_NAME => \App\Commands\RecordUserName::class,
    \App\Services\UserStatusService::PHONE => \App\Commands\RecordPhone::class,
];