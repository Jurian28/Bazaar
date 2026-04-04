<?php

namespace Database\Seeders;

use App\Models\Advertisement;
use App\Models\Company;
use App\Models\Offer;
use App\Models\OfferBid;
use App\Models\Rental;
use App\Models\RentalBid;
use App\Models\Sale;
use App\Models\SaleBid;
use App\Models\CompanyComponent;
use App\Models\Contract;
use App\Models\Review;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Companies
        $company1 = Company::create([ // default company
            'name' => 'default',
            'slug' => 'default',
            'primary_color' => '#3080eb',
            'secondary_color' => '#222222',
        ]);

        $company2 = Company::create([
            'name' => 'ACME',
            'slug' => 'acme',
            'primary_color' => '#222222',
            'secondary_color' => '#d1a294',
        ]);

        // Users
        $companyUser1 = User::create([
            'name' => 'default',
            'email' => 'd@d.d',
            'password' => Hash::make('pass'),
            'user_type' => User::TYPE_COMPANY,
            'company_id' => $company1->id,
        ]);

        $companyUser2 = User::create([
            'name' => 'ACME',
            'email' => 'c@c.c',
            'password' => Hash::make('pass'),
            'user_type' => User::TYPE_COMPANY,
            'company_id' => $company2->id,
        ]);

        $seller = User::create([
            'name' => 'John Doe',
            'email' => 's@s.s',
            'password' => Hash::make('pass'),
            'user_type' => User::TYPE_SELLER,
        ]);

        $buyer1 = User::create([
            'name' => 'Alice Buyer',
            'email' => 'u@u.u',
            'password' => Hash::make('pass'),
            'user_type' => User::TYPE_USER,
        ]);

        $buyer2 = User::create([
            'name' => 'Bob Buyer',
            'email' => 'b@b.b',
            'password' => Hash::make('pass'),
            'user_type' => User::TYPE_USER,
        ]);

        /*
        |--------------------------------------------------------------------------
        | OFFERS
        |--------------------------------------------------------------------------
        */
        $ad1 = Advertisement::create([
            'company_id' => $companyUser1->company_id,
            'user_id' => $companyUser1->id,
            'title' => 'Used iPhone 13 - Good Condition',
            'description' => 'iPhone 13 with minor scratches, works perfectly. Includes charger.',
            'type' => 'offer',
        ]);
        $offer1 = Offer::create([
            'advertisement_id' => $ad1->id,
            'start_price' => 300,
            'end_date' => Carbon::now()->addDays(5),
        ]);

        $ad2 = Advertisement::create([
            'company_id' => $companyUser2->company_id,
            'user_id' => $companyUser2->id,
            'title' => 'Mountain Bike - Trek Marlin 7',
            'description' => 'Lightweight mountain bike, recently serviced. Ideal for trails.',
            'type' => 'offer',
        ]);
        $offer2 = Offer::create([
            'advertisement_id' => $ad2->id,
            'start_price' => 450,
            'end_date' => Carbon::now()->addDays(7),
        ]);

        $ad3_offer = Advertisement::create([
            'company_id' => $company1->id,
            'user_id' => $seller->id,
            'title' => 'Gaming PC (RTX 3070, Ryzen 5)',
            'description' => 'High-performance gaming PC, runs all modern games smoothly.',
            'type' => 'offer',
        ]);
        $offer3 = Offer::create([
            'advertisement_id' => $ad3_offer->id,
            'start_price' => 900,
            'end_date' => Carbon::now()->addDays(3),
        ]);

        // Offer bids
        OfferBid::create([
            'advertisement_id' => $ad1->id,
            'user_id' => $buyer1->id,
            'price' => 320,
            'accepted' => false,
        ]);
        OfferBid::create([
            'advertisement_id' => $ad1->id,
            'user_id' => $buyer2->id,
            'price' => 340,
            'accepted' => true,
        ]);
        OfferBid::create([
            'advertisement_id' => $ad2->id,
            'user_id' => $buyer1->id,
            'price' => 470,
            'accepted' => false,
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
        $rental1 = Rental::create([
            'advertisement_id' => $ad4->id,
            'start_date' => Carbon::now()->addDays(1),
            'end_date' => Carbon::now()->addDays(7),
            'price_per_day' => 35,
        ]);

        $ad5 = Advertisement::create([
            'company_id' => $companyUser2->company_id,
            'user_id' => $companyUser2->id,
            'title' => 'Electric Scooter Rental',
            'description' => 'Convenient city transport, fully charged and ready to go.',
            'type' => 'rental',
        ]);
        $rental2 = Rental::create([
            'advertisement_id' => $ad5->id,
            'start_date' => Carbon::now()->addDays(2),
            'end_date' => Carbon::now()->addDays(10),
            'price_per_day' => 12,
        ]);

        $ad6 = Advertisement::create([
            'company_id' => $company1->id,
            'user_id' => $seller->id,
            'title' => 'DJ Set (Pioneer DDJ-400)',
            'description' => 'Perfect for parties and small events. Includes cables.',
            'type' => 'rental',
        ]);
        $rental3 = Rental::create([
            'advertisement_id' => $ad6->id,
            'start_date' => Carbon::now()->addDays(1),
            'end_date' => Carbon::now()->addDays(5),
            'price_per_day' => 20,
        ]);

        // Rental bids
        RentalBid::create([
            'advertisement_id' => $ad4->id,
            'user_id' => $buyer1->id,
            'start_date' => Carbon::now()->addDays(2),
            'end_date' => Carbon::now()->addDays(4),
            'accepted' => true,
        ]);
        RentalBid::create([
            'advertisement_id' => $ad5->id,
            'user_id' => $buyer2->id,
            'start_date' => Carbon::now()->addDays(3),
            'end_date' => Carbon::now()->addDays(6),
            'accepted' => null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | SALES
        |--------------------------------------------------------------------------
        */
        $ad3 = Advertisement::create([
            'company_id' => $company1->id,
            'user_id' => $seller->id,
            'title' => 'Gaming PC',
            'description' => 'High-performance gaming PC, runs all modern games smoothly.',
            'type' => 'sale',
        ]);
        $sale1 = Sale::create([
            'advertisement_id' => $ad3->id,
            'price' => 1900,
        ]);

        // Sale bids
        SaleBid::create([
            'advertisement_id' => $ad3->id,
            'user_id' => $buyer1->id,
        ]);
        SaleBid::create([
            'advertisement_id' => $ad3->id,
            'user_id' => $buyer2->id,
        ]);

        /*
        |--------------------------------------------------------------------------
        | FAVORITES & REVIEWS
        |--------------------------------------------------------------------------
        */
        // Favorites (no Eloquent model present, insert via DB)
        DB::table('favorites')->insert([
            ['user_id' => $buyer1->id, 'advertisement_id' => $ad1->id, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => $buyer1->id, 'advertisement_id' => $ad4->id, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => $buyer2->id, 'advertisement_id' => $ad2->id, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Reviews
        Review::create([
            'user_id' => $buyer1->id,
            'advertisement_id' => $ad1->id,
            'rating' => 5,
            'comment' => 'Great seller, item as described.'
        ]);
        Review::create([
            'user_id' => $buyer2->id,
            'advertisement_id' => $ad5->id,
            'rating' => 4,
            'comment' => 'Scooter was fun to ride, battery could be better.'
        ]);

        /*
        |--------------------------------------------------------------------------
        | COMPANY COMPONENTS & CONTRACTS
        |--------------------------------------------------------------------------
        */
        CompanyComponent::create([
            'company_id' => $company1->id,
            'type' => 'text',
            'order' => 1,
            'data' => ['title' => 'Welcome to Default', 'text' => 'This is the default company homepage.'],
        ]);
        CompanyComponent::create([
            'company_id' => $company1->id,
            'type' => 'ads',
            'order' => 2,
            'data' => ['title' => 'Recent Ads', 'limit' => 6],
        ]);


        CompanyComponent::create([
            'company_id' => $company2->id,
            'type' => 'text',
            'order' => 1,
            'data' => ['title' => 'ACME', 'text' => 'Welcome to ACME'],
        ]);
        CompanyComponent::create([
            'company_id' => $company2->id,
            'type' => 'ads',
            'order' => 2,
            'data' => ['title' => 'Best Ads', 'limit' => 4],
        ]);


        // Minimal contracts (table has only timestamps)
        Contract::create();
        Contract::create();
    }
}
