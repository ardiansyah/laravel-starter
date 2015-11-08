<?php namespace App\Supports\Settings;

use Illuminate\Support\Facades\Facade;

class SettingFacade extends Facade {

    protected static function getFacadeAccessor() { return 'navigationSetting'; }

}
