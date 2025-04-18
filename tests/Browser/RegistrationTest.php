<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegistrationTest extends DuskTestCase
{

    /** @test */
    public function it_displays_the_registration_form()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    //->assertSee('Register') // of een ander tekstje op de pagina
                    ->assertVisible('form');
        });
    }

    /** @test */
    public function it_registers_a_user_successfully()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->type('name', 'John Doe')
                    ->type('email', 'john@example.com')
                    ->type('password', 'password')
                    ->type('password_confirmation', 'password')
                    ->select('user_type', 'gebruiker')
                    ->press('Register')
                    ->assertAuthenticated();
        });
    }

    /** @test */
    public function it_shows_errors_when_fields_are_missing()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->press('Register')
                    ->assertPathIs('/register');
        });
    }
}
