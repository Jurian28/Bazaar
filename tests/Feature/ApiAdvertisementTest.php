<?php

namespace Tests\Feature;

use App\Models\Advertisement;
use App\Models\Company;
use App\Models\OfferBid;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ApiAdvertisementTest extends TestCase
{
    protected function createDefaultCompany(): Company
    {
        // Ensure default company with ID=1 exists for routes without slug
        DB::table('companies')->insert([
            'id' => 1,
            'name' => 'Default Co',
            'slug' => 'default',
            'primary_color' => '#000000',
            'secondary_color' => '#ffffff',
            'font_family' => 'Arial',
        ]);
        return Company::findOrFail(1);
    }

    public function test_index_lists_ads_and_supports_type_filter(): void
    {
        $company = $this->createDefaultCompany();

        // Create ads of different types
        Advertisement::factory()->for($company)->sale()->count(2)->create();
        Advertisement::factory()->for($company)->rental()->count(1)->create();

        // All
        $this->getJson('/api/v1/ads')
            ->assertOk()
            ->assertJsonStructure(['data']);

        // Filter by type=sale
        $json = $this->getJson('/api/v1/ads?type=sale')
            ->assertOk()
            ->json('data');
        $this->assertIsArray($json);
        $this->assertGreaterThanOrEqual(2, count($json));
    }

    public function test_show_returns_full_ad_with_relations(): void
    {
        $company = $this->createDefaultCompany();
        $ad = Advertisement::factory()->for($company)->offer()->create();
        OfferBid::factory()->for($ad, 'advertisement')->count(2)->create();

        $this->getJson('/api/v1/ads/' . $ad->id)
            ->assertOk()
            ->assertJsonPath('id', $ad->id)
            ->assertJsonStructure([
                'id', 'type', 'offer', 'offer_bids', 'company', 'user',
            ]);
    }

    public function test_store_requires_auth_and_role(): void
    {
        $company = Company::factory()->create();

        $this->postJson('/api/v1/c/'.$company->slug.'/ads', [
            'title' => 'X',
            'description' => 'Y',
            'type' => 'sale',
            'price' => 10,
        ])->assertStatus(401);

        // Authenticated normal user → 403
        $user = User::factory()->create(['user_type' => User::TYPE_USER]);
        $this->actingAs($user);
        $this->postJson('/api/v1/c/'.$company->slug.'/ads', [
            'title' => 'X',
            'description' => 'Y',
            'type' => 'sale',
            'price' => 10,
        ])->assertStatus(403);
    }

    public function test_store_as_seller_and_company_succeeds_for_each_type(): void
    {
        $company = Company::factory()->create();

        // Seller creates sale ad
        $seller = User::factory()->create(['user_type' => User::TYPE_SELLER]);
        $this->actingAs($seller);
        $this->postJson('/api/v1/c/'.$company->slug.'/ads', [
            'title' => 'Sale Drill',
            'description' => 'Nice',
            'type' => 'sale',
            'price' => 25,
        ])->assertCreated()->assertJsonPath('type', 'sale');

        // Seller creates rental ad
        $this->postJson('/api/v1/c/'.$company->slug.'/ads', [
            'title' => 'Rental Saw',
            'description' => 'Per day',
            'type' => 'rental',
            'price_per_day' => 5,
            'start_date' => '2027-02-02',
            'rental_end_date' => '2027-03-03',
        ])->assertCreated()->assertJsonPath('type', 'rental');

        // company user creates offer ad (company is taken from auth user)
        $authCompany = Company::factory()->create();
        $companyUser = User::factory()->create([
            'user_type' => User::TYPE_COMPANY,
            'company_id' => $authCompany->id,
        ]);
        $this->actingAs($companyUser);
        $this->postJson('/api/v1/c/'.$company->slug.'/ads', [
            'title' => 'Offer Grinder',
            'description' => 'Bid now',
            'type' => 'offer',
            'start_price' => 1,
            'offer_end_date' => now()->toDateString(),
        ])->assertCreated()->assertJsonPath('company_id', $authCompany->id);
    }
}
