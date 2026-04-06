<?php

namespace Tests\Browser;

use App\Models\Advertisement;
use App\Models\Company;
use App\Models\Sale;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdsBrowsingTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        // Ensure default company exists for pages without slug
        Company::factory()->defaultCompany()->create();
    }

    public function test_user_can_browse_ads_and_view_detail(): void
    {
        $ad = Advertisement::factory()->sale()->create(['title' => 'Browser Test Saw']);
        Sale::factory()->create(['advertisement_id' => $ad->id, 'price' => 42]);

        $this->browse(function (Browser $browser) use ($ad) {
            $browser->visit('/ads')
                ->assertSee('Browser Test Saw')
                ->clickLink('Browser Test Saw')
                ->assertPathIs('/ads/'.$ad->id)
                ->assertSee('Browser Test Saw');
        });
    }
}
