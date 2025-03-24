<?php

namespace Kowap\SendPulse;

use Illuminate\Support\Facades\Facade;

class SendPulse extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'sendpulse';
    }
}
