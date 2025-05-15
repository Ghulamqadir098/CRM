<?php

namespace App\Policies;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CartPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function addToCart(User $user, Cart $cart): bool
    {
       if($user->can('add to cart') && $cart->user_id == $user->id){
        return true;
       }
       return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function viewCart(User $user, Cart $cart): bool
    {
        if($user->can('view cart') && $cart->user_id == $user->id){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function removeFromCart(User $user, Cart $cart): bool
    {
        if($user->can('remove from cart') && $cart->user_id == $user->id){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function viewAllCarts(User $user): bool
    {
        return $user->can('view all carts');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Cart $cart): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Cart $cart): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Cart $cart): bool
    {
        return false;
    }
}
