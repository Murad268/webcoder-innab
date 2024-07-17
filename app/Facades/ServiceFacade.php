<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'App\Services\SettingsService';
    }
}
