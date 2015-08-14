<?php namespace App\Supports\Permission;

use Illuminate\Support\Facades\Facade;

class PermissionsFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'registerPermissions'; }

}
