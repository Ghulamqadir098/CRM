<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Lead;
use App\Models\Order;
use App\Models\Product;
use App\Policies\CartPolicy;
use App\Policies\LeadPolicy;
use App\Policies\OrderPolicy;
use App\Policies\ProductPolicy;
use App\Policies\ServicePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Manually register model-policy mappings
    Gate::policy(Product::class, ProductPolicy::class);
    Gate::policy(Cart::class, CartPolicy::class);
    Gate::policy(Order::class, OrderPolicy::class);
    Gate::policy(Lead::class, LeadPolicy::class);

    
        // Product Gate
        Gate::define('read-all-products', [ProductPolicy::class, 'readAllProducts']);
        Gate::define('read-product', [ProductPolicy::class, 'readProduct']);
        Gate::define('create-product', [ProductPolicy::class, 'createProduct']);
        Gate::define('update-product', [ProductPolicy::class, 'updatePoduct']);
        Gate::define('delete-product', [ProductPolicy::class, 'deleteProduct']);

        // Service Gate
        Gate::define('read-all-services', [ServicePolicy::class, 'readAllServices']);
        Gate::define('read-service', [ServicePolicy::class, 'readService']);
        Gate::define('create-service', [ServicePolicy::class, 'createService']);
        Gate::define('update-service', [ServicePolicy::class, 'updateService']);
        Gate::define('delete-service', [ServicePolicy::class, 'deleteService']);

        // Lead Gate
        Gate::define('read-all-leads', [LeadPolicy::class, 'readAllLeads']);
        Gate::define('read-lead', [LeadPolicy::class, 'readLead']);
        Gate::define('create-lead', [LeadPolicy::class, 'createLead']);
        Gate::define('update-lead', [LeadPolicy::class, 'updateLead']);
        Gate::define('delete-lead', [LeadPolicy::class, 'deleteLead']);

        // Cart Gate
        Gate::define('view-all-carts', [CartPolicy::class, 'viewAllCarts']);
        Gate::define('add-to-cart', [CartPolicy::class, 'addToCart']);
        Gate::define('view-cart', [CartPolicy::class, 'viewCart']);
        Gate::define('remove-from-cart', [CartPolicy::class, 'removeFromCart']);

        // Order Gate
        Gate::define('place-order', [OrderPolicy::class, 'placeOrder']);
        Gate::define('view-all-orders', [OrderPolicy::class, 'viewAllOrders']);
        Gate::define('view-order', [OrderPolicy::class, 'viewOrder']);
        Gate::define('view-orders', [OrderPolicy::class, 'viewOrders']);

    }
}
