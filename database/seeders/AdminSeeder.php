<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin already exists by email
        $admin = User::where('email', 'furniscapestore@gmail.com')->first();

        if ($admin) {
            // Update existing admin just to be safe
            $admin->update([
                'name' => 'FurniScape Admin',
                'phone_no' => '0810005555',
                'password' => Hash::make('FurniScape@123'),
                'role' => 'admin',
            ]);
        } else {
            // Create new admin
            User::create([
                'email' => 'furniscapestore@gmail.com',
                'name' => 'FurniScape Admin',
                'phone_no' => '0810005555',
                'password' => Hash::make('FurniScape@123'),
                'role' => 'admin',
                'email_verified_at' => now(), 
            ]);
        }
    }
}
