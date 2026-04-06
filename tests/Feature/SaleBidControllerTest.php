<?php

namespace Tests\Feature;

use App\Models\Advertisement;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SaleBidControllerTest extends TestCase
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

    public function test_user_can_buy_sale_ad_and_record_is_created(): void
    {
        $company = $this->createDefaultCompany();
        $ad = Advertisement::factory()->for($company)->sale()->create();
        $user = User::factory()->create(['user_type' => User::TYPE_USER]);
        $this->actingAs($user);

        $this->post('/ads/'.$ad->id.'/buy')->assertRedirect();

        $this->assertDatabaseHas('sale_bids', [
            'advertisement_id' => $ad->id,
            'user_id' => $user->id,
        ]);
    }

    public function test_buying_non_sale_ad_returns_404(): void
    {
        $company = $this->createDefaultCompany();
        $ad = Advertisement::factory()->for($company)->rental()->create();
        $user = User::factory()->create(['user_type' => User::TYPE_USER]);
        $this->actingAs($user);

        $this->post('/ads/'.$ad->id.'/buy')->assertNotFound();
    }
}
