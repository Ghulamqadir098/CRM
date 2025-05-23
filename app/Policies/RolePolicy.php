<?php

namespace App\Policies;


use App\Models\User;
use Illuminate\Auth\Access\Response;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function createRole(User $user): bool
    {
        return $user->can('create role');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function readRole(User $user): bool
    {
        return $user->can('read role');
    }

    /**
     * Determine whether the user can create models.
     */
  

    /**
     * Determine whether the user can update the model.
     */
    public function updateRole(User $user): bool
    {
        return $user->can('update role');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function deleteRole(User $user): bool
    {
        return $user->can('delete role');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): bool
    {
        return false;
    }
}
