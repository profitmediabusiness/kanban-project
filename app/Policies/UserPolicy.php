<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function __construct()
    {
        //
    }

    protected function getUserPermissions($user){

        return $user
        ->role()
        ->with('permissions')
        ->get()
        ->pluck('permissions')
        ->flatten()
        ->pluck('name');
    }

    public function viewOtherUsersAndTheirRoles($user){

        $permissions = $this->getUserPermissions($user);

        if ($permissions->contains('view-users-and-roles')) {
            return true;
        }
    
        return false;
    }


    public function before($user)
    {
        if ($user->role && $user->role->name == 'admin') {
            return true;
        }
    
        return null;
    }
}

