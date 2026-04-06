<?php

namespace Tests\Unit;

use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CompanyModelTest extends TestCase
{
    public function test_getDefaultCompany_returns_company_with_id_1(): void
    {
        DB::table('companies')->insert([
            'id' => 1,
            'name' => 'Default Co',
            'slug' => 'default',
            'primary_color' => '#000000',
            'secondary_color' => '#ffffff',
            'font_family' => 'Arial',
        ]);

        $default = Company::getDefaultCompany();
        $this->assertNotNull($default);
        $this->assertEquals(1, $default->id);
    }

    public function test_getBySlug_returns_default_when_null_and_specific_when_present(): void
    {
        DB::table('companies')->insert([
            'id' => 1,
            'name' => 'Default Co',
            'slug' => 'default',
            'primary_color' => '#000000',
            'secondary_color' => '#ffffff',
            'font_family' => 'Arial',
        ]);

        $specific = Company::factory()->create(['slug' => 'acme-inc']);

        $byNull = Company::getBySlug(null);
        $this->assertEquals(1, $byNull->id);

        $bySlug = Company::getBySlug('acme-inc');
        $this->assertEquals($specific->id, $bySlug->id);
    }
}
