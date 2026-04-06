<?php

namespace Tests\Unit;

use App\Models\Advertisement;
use App\Models\Company;
use App\Models\OfferBid;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdvertisementModelTest extends TestCase
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

    public function test_type_helpers(): void
    {
        $company = $this->createDefaultCompany();
        $sale = Advertisement::factory()->for($company)->sale()->create();
        $rental = Advertisement::factory()->for($company)->rental()->create();
        $offer = Advertisement::factory()->for($company)->offer()->create();

        $this->assertTrue($sale->isSale());
        $this->assertFalse($sale->isRental());
        $this->assertFalse($sale->isOffer());

        $this->assertTrue($rental->isRental());
        $this->assertFalse($rental->isSale());
        $this->assertFalse($rental->isOffer());

        $this->assertTrue($offer->isOffer());
        $this->assertFalse($offer->isSale());
        $this->assertFalse($offer->isRental());
    }

    public function test_offerAccepted_false_when_not_offer_or_no_accepted(): void
    {
        $company = $this->createDefaultCompany();
        $sale = Advertisement::factory()->for($company)->sale()->create();
        $this->assertFalse($sale->offerAccepted());

        $offer = Advertisement::factory()->for($company)->offer()->create();
        $this->assertFalse($offer->offerAccepted());
    }

    public function test_offerAccepted_true_when_accepted_bid_exists(): void
    {
        $company = $this->createDefaultCompany();
        $offer = Advertisement::factory()->for($company)->offer()->create();
        OfferBid::factory()->for($offer, 'advertisement')->create(['accepted' => true]);

        $this->assertTrue($offer->offerAccepted());
    }
}
