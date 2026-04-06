<?php

namespace Tests\Feature;

use App\Models\Advertisement;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class AdControllerTest extends TestCase
{
    protected function createDefaultCompany(): Company
    {
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

    public function test_ads_page_lists_ads_and_supports_search(): void
    {
        $company = $this->createDefaultCompany();
        Advertisement::factory()->for($company)->sale()->create(['title' => 'Blue Drill']);
        Advertisement::factory()->for($company)->sale()->create(['title' => 'Red Hammer']);

        // Without search
        $res = $this->get('/ads');
        $res->assertStatus(200);
        $res->assertSee('Blue Drill');
        $res->assertSee('Red Hammer');

        // With search
        $this->get('/ads?search=Drill')->assertSee('Blue Drill')->assertDontSee('Red Hammer');
    }

    public function test_create_sale_ad_by_seller_creates_sale_record(): void
    {
        $this->createDefaultCompany();
        $company = Company::factory()->create();
        $seller = User::factory()->create(['user_type' => User::TYPE_SELLER]);
        $this->actingAs($seller);

        $this->post('/ad/create', [
            'title' => 'Sale Item',
            'description' => 'Desc',
            'type' => 'sale',
            'price' => 12.34,
        ])->assertStatus(200);

        $this->assertDatabaseHas('advertisements', ['title' => 'Sale Item', 'type' => 'sale']);
        $this->assertDatabaseCount('sales', 1);
    }

    public function test_create_offer_ad_requires_fields_and_creates_offer(): void
    {
        $company = Company::factory()->create();
        $seller = User::factory()->create(['user_type' => User::TYPE_SELLER]);
        $this->actingAs($seller);

        // Missing required offer fields -> 302
        $this->post('/ad/create', [
            'title' => 'Offer Item',
            'description' => 'Desc',
            'type' => 'offer',
        ])->assertStatus(302);

        $this->post('/ad/create', [
            'title' => 'Offer Item',
            'description' => 'Desc',
            'type' => 'offer',
            'start_price' => 5,
            'offer_end_date' => now()->toDateString(),
        ])->assertStatus(200);

        $this->assertDatabaseHas('advertisements', ['title' => 'Offer Item', 'type' => 'offer']);
        $this->assertDatabaseCount('offers', 1);
    }
}
