<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user=new User();
        $user->name= 'Admin';
        $user->email='admin@gmail.com';
        $user->password = bcrypt('password');
        // verify email now 
        $user->email_verified_at = now();
        $user->role='admin';
        $user->save();
        $user->assignRole('admin');

    }
}

