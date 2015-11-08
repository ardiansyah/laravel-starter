<?php
namespace App\Supports\Permission;

class Permissions
{
    protected $permissionItems = [];

    protected $permissions = [];

    public function register($permissions)
    {
        $this->permissionItems = array_merge($this->permissionItems, $permissions);
    }

    public function render()
    {
        // return $this->permissions;
        foreach ($this->permissionItems as $key => $permission) {
            $item = (object) array_merge([], $permission);

            $this->permissions[$key] = $item;
        }

        return $this->permissions;
    }
}
