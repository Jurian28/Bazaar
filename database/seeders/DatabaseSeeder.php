<?php

namespace Database\Seeders;

use App\Models\Advertisement;
use App\Models\Company;
use App\Models\Rental;
use App\Models\Sale;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
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
            'primary_color' => '#6b7280',
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


        $companyUser1 = User::create([
            'name' => "default",
            'email' => "d@d.d",
            'password' => Hash::make('pass'),
            'user_type' => User::TYPE_COMPANY,
            'company_id' => $company1->id,
        ]);


        $companyUser2 = User::create([
            'name' => "ACME",
            'email' => "c@c.c",
            'password' => Hash::make('pass'),
            'user_type' => User::TYPE_COMPANY,
            'company_id' => $company2->id,
        ]);


        $seller = User::create([
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

        /*
        |--------------------------------------------------------------------------
        | SALES
        |--------------------------------------------------------------------------
        */

        $ad1 = Advertisement::create([
            'company_id' => $companyUser1->company_id,
            'user_id' => $companyUser1->id,
            'title' => 'Used iPhone 13 - Good Condition',
            'description' => 'iPhone 13 with minor scratches, works perfectly. Includes charger.',
            'type' => 'sale',
        ]);

        Sale::create([
            'advertisement_id' => $ad1->id,
            'start_price' => 300,
            'end_time' => Carbon::now()->addDays(5),
            'max_bids' => 15,
        ]);

        $ad2 = Advertisement::create([
            'company_id' => $companyUser2->company_id,
            'user_id' => $companyUser2->id,
            'title' => 'Mountain Bike - Trek Marlin 7',
            'description' => 'Lightweight mountain bike, recently serviced. Ideal for trails.',
            'type' => 'sale',
        ]);

        Sale::create([
            'advertisement_id' => $ad2->id,
            'start_price' => 450,
            'end_time' => Carbon::now()->addDays(7),
            'max_bids' => 10,
        ]);

        $ad3 = Advertisement::create([
            'company_id' => $company1->id,
            'user_id' => $seller->id,
            'title' => 'Gaming PC (RTX 3070, Ryzen 5)',
            'description' => 'High-performance gaming PC, runs all modern games smoothly.',
            'type' => 'sale',
        ]);

        Sale::create([
            'advertisement_id' => $ad3->id,
            'start_price' => 900,
            'end_time' => Carbon::now()->addDays(3),
            'max_bids' => 20,
        ]);

        /*
        |--------------------------------------------------------------------------
        | RENTALS
        |--------------------------------------------------------------------------
        */

        $ad4 = Advertisement::create([
            'company_id' => $companyUser1->company_id,
            'user_id' => $companyUser1->id,
            'title' => 'Camera Rental - Canon EOS R6',
            'description' => 'Professional mirrorless camera, perfect for events and shoots.',
            'type' => 'rental',
        ]);

        Rental::create([
            'advertisement_id' => $ad4->id,
            'start_date' => Carbon::now()->addDays(1),
            'end_date' => Carbon::now()->addDays(7),
            'price_per_day' => 35,
            'wear_level' => 2,
            'max_rentals' => 5,
        ]);

        $ad5 = Advertisement::create([
            'company_id' => $companyUser2->company_id,
            'user_id' => $companyUser2->id,
            'title' => 'Electric Scooter Rental',
            'description' => 'Convenient city transport, fully charged and ready to go.',
            'type' => 'rental',
        ]);

        Rental::create([
            'advertisement_id' => $ad5->id,
            'start_date' => Carbon::now()->addDays(2),
            'end_date' => Carbon::now()->addDays(10),
            'price_per_day' => 12,
            'wear_level' => 3,
            'max_rentals' => 8,
        ]);

        $ad6 = Advertisement::create([
            'company_id' => $company1->id,
            'user_id' => $seller->id,
            'title' => 'DJ Set (Pioneer DDJ-400)',
            'description' => 'Perfect for parties and small events. Includes cables.',
            'type' => 'rental',
        ]);

        Rental::create([
            'advertisement_id' => $ad6->id,
            'start_date' => Carbon::now()->addDays(1),
            'end_date' => Carbon::now()->addDays(5),
            'price_per_day' => 20,
            'wear_level' => 2,
            'max_rentals' => 3,
        ]);


    }
}
