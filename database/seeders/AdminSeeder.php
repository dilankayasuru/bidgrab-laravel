<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => "BidGarb Admin",
            'email' => "admin@bidgrab.com",
            'password' => Hash::make("asd@ASD12"),
        ]);
        $user->role = 'admin';
        $user->save();
    }
}
