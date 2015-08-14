<?php namespace App\Supports\Navigation;

use Illuminate\Support\Facades\Facade;

class NavigationFacade extends Facade {

    protected static function getFacadeAccessor() { return 'navigation'; }

}
