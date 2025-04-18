<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{

    /** @test */
    public function it_displays_the_login_form()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertVisible('form');
        });
    }

    /** @test */
    public function it_logs_in_with_correct_credentials()
    {
        $user = User::factory()->create([
            'email' => 'joh@example.com',
            'password' => bcrypt('secret123'),
            'user_type' => 'gebruiker'
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                    ->type('email', 'joh@example.com')
                    ->type('password', 'secret123')
                    ->press('Login') // pas aan indien jouw knop anders heet
                    ->assertPathIs('/')
                    ->assertAuthenticatedAs($user);
        });
    }

    /** @test */
    public function it_shows_error_on_invalid_credentials()
    {
        User::factory()->create([
            'email' => 'jo@example.com',
            'password' => bcrypt('correctpassword'),
            'user_type' => 'gebruiker'
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'jo@example.com')
                    ->type('password', 'wrongpassword')
                    ->press('Login')
                    ->assertPathIs('/login');
        });
    }

    /** @test */
    public function it_logs_out_successfully()
    {
        $user = User::factory()->create([
            'email' => 'j@example.com',
            'password' => bcrypt('cpassword'),
            'user_type' => 'gebruiker'
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/')
                    ->press('Log Out') // gebruik Dusk selector of pas aan
                    ->assertGuest()
                    ->assertPathIs('/');
        });
    }
}
