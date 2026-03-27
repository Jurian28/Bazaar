<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $company1 = Company::create([ // default company
            'name' => 'default',
            'slug' => '',
            'primary_color' => '#111111',
            'secondary_color' => '$222222',
            'logo_url' => '',
        ]);


        $company2 = Company::create([ // default company
            'name' => 'ACME',
            'slug' => 'ACME',
            'primary_color' => '#111111',
            'secondary_color' => '$222222',
            'logo_url' => '',
        ]);


        User::create([
            'name' => "default",
            'email' => "d@d.d",
            'password' => Hash::make('pass'),
            'user_type' => User::TYPE_COMPANY,
            'company_id' => $company1->id,
        ]);


        User::create([
            'name' => "ACME",
            'email' => "c@c.c",
            'password' => Hash::make('pass'),
            'user_type' => User::TYPE_COMPANY,
            'company_id' => $company2->id,
        ]);


        User::create([
            'name' => "John Doe",
            'email' => "s@s.s",
            'password' => Hash::make('pass'),
            'user_type' => User::TYPE_SELLER,
        ]);


        User::create([
            'name' => "John Doe",
            'email' => "u@u.u",
            'password' => Hash::make('pass'),
            'user_type' => User::TYPE_USER,
        ]);

    }
}
