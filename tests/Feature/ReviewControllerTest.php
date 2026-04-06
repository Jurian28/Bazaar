<?php

namespace Tests\Feature;

use App\Models\Advertisement;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ReviewControllerTest extends TestCase
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

    public function test_review_ad_requires_auth(): void
    {
        $company = $this->createDefaultCompany();
        $ad = Advertisement::factory()->for($company)->sale()->create();

        $this->post('/ads/'.$ad->id.'/review', [
            'rating' => '5',
            'comment' => 'Great product',
        ])->assertStatus(403);
    }

    public function test_review_ad_success_with_auth(): void
    {
        $company = $this->createDefaultCompany();
        $ad = Advertisement::factory()->for($company)->sale()->create();
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->post('/ads/'.$ad->id.'/review', [
            'rating' => '4',
            'comment' => 'Nice',
        ])->assertRedirect();

        $this->assertDatabaseHas('reviews', [
            'advertisement_id' => $ad->id,
            'user_sender_id' => $user->id,
            'rating' => '4',
            'comment' => 'Nice',
        ]);
    }
}
