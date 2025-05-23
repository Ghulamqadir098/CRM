<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            // Clear cache
            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    
            // Create Permissions
            $permissions = [
                // Product CRUD
                'create product',
                'read product',
                'update product',
                'delete product',
                'read all products',
    
                // Service CRUD
                'create service',
                'read service',
                'update service',
                'delete service',
                'read all services',
    
                //Lead
                'create lead',
                'read lead',
                'read own leads',
                'update lead',
                'delete lead',
                'read all leads',

                // Cart
                'add to cart',
                'view cart',
                'remove from cart',
                'view all carts',
    
                // Order
                'place order',
                'view order',
                'view orders',
                'view all orders',

                // User 
                'read all users',
                'read own customers',
                'read own agent',
                'create agent',
                'create customer',
                
                // Roles
                'create role',
                'read role',
                'update role',
                'delete role',
            ];
    
            foreach ($permissions as $permission) {
                Permission::firstOrCreate(['name' => $permission]);
            }
    
            // Create Roles
            $admin = Role::firstOrCreate(['name' => 'admin']);
            $agent = Role::firstOrCreate(['name' => 'agent']);
            $customer = Role::firstOrCreate(['name' => 'customer']);
    
            // Assign permissions to admin
            $admin->givePermissionTo([
                'create product', 'read product', 'update product', 'delete product',
                'create service', 'read service', 'update service', 'delete service',
               
                'view all carts', 'view all orders','read all products','read all services','read all leads',
               //users
                'read all users','create agent','create customer',
               //roles 
               'create role',
                'read role',
                'update role',
                'delete role',

            ]);
    
            // Agent  permissions 
            $agent->givePermissionTo([
                'create lead', 'read lead', 'update lead', 'delete lead','read own customers','read own leads',
            ]);
    
            // Assign permissions to customer
            $customer->givePermissionTo([
                'add to cart', 'view cart', 'remove from cart',
                'place order', 'view orders','view order','read own agent'
            ]);
        }
    }
}
