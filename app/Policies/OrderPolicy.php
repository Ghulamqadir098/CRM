<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function placeOrder(User $user, Order $order): bool
    {
       if($user->can('place order') && $order->user_id == $user->id){
        return true;
       }
       return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function viewOrders(User $user): bool
    {
        return $user->can('view orders');
    }
    
    public function viewOrder(User $user, Order $order): bool
    {
        if($user->can('view order') && $order->user_id == $user->id){
         return true;
        }
        return false;
    }
    /**
     * Determine whether the user can create models.
     */
    public function viewAllOrders(User $user): bool
    {
        return $user->can('view all orders');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Order $order): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Order $order): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Order $order): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Order $order): bool
    {
        return false;
    }
}
