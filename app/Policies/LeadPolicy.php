<?php

namespace App\Policies;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LeadPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function readAllLeads(User $user): bool
    {
        return $user->can('read all leads');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function readLead(User $user, Lead $lead): bool
    {
        // check if usr can view lead and lead belongs to his leads only
       if($user->can('read lead') && $lead->user_id == $user->id){
        return true;
       }
     return false;   
    }

    /**
     * Determine whether the user can create models.
     */
    public function createLead(User $user): bool
    {
        return $user->can('create lead');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function updateLead(User $user, Lead $lead): bool
    {
        if($user->can('update lead') && $lead->user_id == $user->id){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function deleteLead(User $user, Lead $lead): bool
    {
        if($user->can('delete lead') && $lead->user_id == $user->id){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Lead $lead): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Lead $lead): bool
    {
        return false;
    }
}
