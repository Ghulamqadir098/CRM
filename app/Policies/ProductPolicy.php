<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function readAllProducts(User $user): bool
    {
        return $user->can('read all products');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function readProduct(User $user): bool
    {
        return $user->can('read product');
    }

    /**
     * Determine whether the user can create models.
     */
    public function createProduct(User $user): bool
    {
        
        return $user->can('create product');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function updatePoduct(User $user): bool
    {
        return $user->can('update product');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function deleteProduct(User $user): bool
    {
        return $user->can('delete product');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Product $product): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Product $product): bool
    {
        return false;
    }
}
