<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UsersCanLoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    function users_can_login()
    {
        factory(User::class)->create(['email' => 'checha@mail.com']);

        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'checha@mail.com')
                ->type('password', 'secret')
                ->press('@login-btn')
                ->assertPathIs('/')
                ->assertAuthenticated();
        });
    }

    /** @test */
    function users_cannot_login_with_invalid_data()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', '')
                ->press('@login-btn')
                ->assertPathIs('/login')
                ->assertPresent('@validation-errors');
        });
    }
}
