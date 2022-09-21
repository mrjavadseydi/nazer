<?php

namespace App\Traits;


use App\Models\Role;

trait HasPermissionsTrait
{
    public function getRole()
    {
        return $this->role->name;
    }

    public function getRoleObject()
    {
        return $this->role;
    }

    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->role->name === $role;
        }

        return $role->contains('name', $this->role->name);
    }

    public function getPermissions($role)
    {
        return Role::where('name', $role)->first()->permissions;
    }

    public function hasPermission($permission) {
        return $this->role->permissions->contains('name', $permission);
    }
}
