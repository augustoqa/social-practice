<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersCanRegisterTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    function users_can_register()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->type('name', 'CesarAcual')
                    ->type('first_name', 'Cesar')
                    ->type('last_name', 'Acual')
                    ->type('email', 'cesar@mail.com')
                    ->type('password', 'secret')
                    ->type('password_confirmation', 'secret')
                    ->press('@register-btn')
                    ->assertPathIs('/')
                    ->assertAuthenticated();
        });
    }

    /** @test */
    function users_cannot_register_with_invalid_information()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('name', '')
                ->press('@register-btn')
                ->assertPathIs('/register')
                ->assertPresent('@validation-errors');
        });
    }
}
