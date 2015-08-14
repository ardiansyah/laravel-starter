<?php
namespace App\Supports\Permission;

class Permissions
{
    protected $permissions = array();

    public function register($permissions)
    {
        $this->permissions = (object) array_merge($this->permissions, $permissions);
    }

    public function get()
    {
        return $this->permissions;
    }
}
