<?php

namespace App\Policies;

use App\Models\Service;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ServicePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function readAllServices(User $user): bool
    {
        return $user->can('read all services');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function readService(User $user): bool
    {
        return $user->can('read service');
    }

    /**
     * Determine whether the user can create models.
     */
    public function createService(User $user): bool
    {
       return $user->can('create service');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function updateService(User $user): bool
    {
        return $user->can('update service');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function deleteService(User $user): bool
    {
        return $user->can('delete service');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Service $service): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Service $service): bool
    {
        return false;
    }
}
