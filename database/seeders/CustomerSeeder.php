<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user=new User();
        $user->name= 'Customer';
        $user->email='customer@gmail.com';
        $user->password = bcrypt('password');
        // verify email now 
        $user->agent_id=2;
        $user->email_verified_at = now();
        $user->role='customer';
        $user->save();
        $user->assignRole('customer');
    }
}
