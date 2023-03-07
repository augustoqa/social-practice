<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function users_can_register()
    {
        $this->withoutExceptionHandling();

        $response = $this->post(route('register'), $this->userValidData());

        $response->assertRedirect('/');

        $this->assertDatabaseHas('users', [
            'name' => 'CesarAcual2',
            'first_name' => 'Cesar',
            'last_name' => 'Acual',
            'email' => 'cesar@mail.com',
        ]);

        $this->assertTrue(
            Hash::check('secret', User::first()->password),
            'The password needs to be hashed'
        );
    }

    /** @test */
    function the_name_must_be_required()
    {
        $this->post(route('register'), $this->userValidData([
            'name' => null,
        ]))->assertSessionHasErrors('name');
    }

    /** @test */
    function the_name_must_be_unique()
    {
        factory(User::class)->create(['name' => 'CesarAcual']);

        $this->post(route('register'), $this->userValidData([
            'name' => 'Cesar Acual',
        ]))->assertSessionHasErrors('name');
    }

    /** @test */
    function the_name_may_only_contain_letter_and_numbers()
    {
        $this->post(route('register'), $this->userValidData([
            'name' => 'Cesar Acual',
        ]))->assertSessionHasErrors('name');

        $this->post(route('register'), $this->userValidData([
            'name' => 'CesarAcual<>',
        ]))->assertSessionHasErrors('name');
    }

    /** @test */
    function the_name_must_be_a_string()
    {
        $this->post(route('register'), $this->userValidData([
            'name' => 12345,
        ]))->assertSessionHasErrors('name');
    }

    /** @test */
    function the_name_may_not_be_greater_than_60_characters()
    {
        $this->post(route('register'), $this->userValidData([
            'name' => str_random(61),
        ]))->assertSessionHasErrors('name');
    }

    /** @test */
    function the_name_must_be_at_least_3_characters()
    {
        $this->post(route('register'), $this->userValidData([
            'name' => 'ab',
        ]))->assertSessionHasErrors('name');
    }

    /** @test */
    function the_first_name_is_required()
    {
        $this->post(route('register'), $this->userValidData([
            'first_name' => null,
        ]))->assertSessionHasErrors('first_name');
    }

    /** @test */
    function the_first_name_must_be_a_string()
    {
        $this->post(route('register'), $this->userValidData([
            'first_name' => 12345,
        ]))->assertSessionHasErrors('first_name');
    }

    /** @test */
    function first_name_may_not_be_greater_than_60_characters()
    {
        $this->post(route('register'), $this->userValidData([
            'first_name' => str_random(61),
        ]))->assertSessionHasErrors('first_name');
    }

    /** @test */
    function the_first_name_must_be_at_least_3_characters()
    {
        $this->post(route('register'), $this->userValidData([
            'first_name' => 'ab',
        ]))->assertSessionHasErrors('first_name');
    }

    /** @test */
    function the_first_name_may_only_contain_letters()
    {
        $this->post(route('register'), $this->userValidData([
            'first_name' => 'Cesar2',
        ]))->assertSessionHasErrors('first_name');

        $this->post(route('register'), $this->userValidData([
            'first_name' => 'Cesar<>',
        ]))->assertSessionHasErrors('first_name');
    }

    /** @test */
    function the_last_name_is_required()
    {
        $this->post(route('register'), $this->userValidData([
            'last_name' => null,
        ]))->assertSessionHasErrors('last_name');
    }

    /** @test */
    function the_last_name_must_be_a_string()
    {
        $this->post(route('register'), $this->userValidData([
            'last_name' => 12345,
        ]))->assertSessionHasErrors('last_name');
    }

    /** @test */
    function last_name_may_not_be_greater_than_60_characters()
    {
        $this->post(route('register'), $this->userValidData([
            'last_name' => str_random(61),
        ]))->assertSessionHasErrors('last_name');
    }

    /** @test */
    function the_last_name_must_be_at_least_3_characters()
    {
        $this->post(route('register'), $this->userValidData([
            'last_name' => 'ab',
        ]))->assertSessionHasErrors('last_name');
    }

    /** @test */
    function the_last_name_may_only_contain_letters()
    {
        $this->post(route('register'), $this->userValidData([
            'last_name' => 'Acual2',
        ]))->assertSessionHasErrors('last_name');

        $this->post(route('register'), $this->userValidData([
            'last_name' => 'Acual<>',
        ]))->assertSessionHasErrors('last_name');
    }

    /** @test */
    function the_email_is_required()
    {
        $this->post(route('register'), $this->userValidData([
            'email' => null,
        ]))->assertSessionHasErrors('email');
    }

    /** @test */
    function the_email_must_be_a_valid_email_address()
    {
        $this->post(route('register'), $this->userValidData([
            'email' => 'aleatorio@some',
        ]))->assertSessionHasErrors('email');
    }

    /** @test */
    function the_email_must_be_unique()
    {
        factory(User::class)->create(['email' => 'cesar@mail.com']);

        $this->post(route('register'), $this->userValidData([
            'email' => 'cesar@mail.com',
        ]))->assertSessionHasErrors('email');
    }


    /** @test */
    function the_password_is_required()
    {
        $this->post(route('register'), $this->userValidData([
            'password' => null,
        ]))->assertSessionHasErrors('password');
    }

    /** @test */
    function the_password_must_be_a_string()
    {
        $this->post(route('register'), $this->userValidData([
            'password' => 12345,
        ]))->assertSessionHasErrors('password');
    }

    /** @test */
    function the_password_must_be_at_least_6_characters()
    {
        $this->post(route('register'), $this->userValidData([
            'password' => 'abcde',
        ]))->assertSessionHasErrors('password');
    }

    /** @test */
    function the_password_must_be_confirmed()
    {
        $this->post(route('register'), $this->userValidData([
            'password' => 'secret',
            'password_confirmation' => null,
        ]))->assertSessionHasErrors('password');
    }

    /**
     * @return string[]
     */
    public function userValidData(array $overrides = []): array
    {
        return array_merge([
            'name' => 'CesarAcual2',
            'first_name' => 'Cesar',
            'last_name' => 'Acual',
            'email' => 'cesar@mail.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ], $overrides);
    }
}
