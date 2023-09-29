<?php

namespace App\Policies;

use App\Models\User;

class RolePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }


    public function getUsersPermission(User $user){
        return $user
        ->role()
        ->with('permissions')
        ->get()
        ->pluck('permissions')
        ->flatten()
        ->pluck('name');
    }

    public function before(User $user){
        if ($user->role && $user->role->name == 'admin') {
            return true;
        }
    
        return null;
    }

    public function viewAllRoles(User $user){
        $p=$this->getUsersPermission($user);
        if($p->contains('view-all-role')){
            return true;
        }
        return false;
    }

    public function manageRoles(User $user){
        $p=$this->getUsersPermission($user);
        if($p->contains('manage-roles')){
            return true;
        }
        return false;
    }
}
