<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateStatusTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guests_users_can_not_create_statuses() {
        $response = $this->post(route('statuses.store'), ['body' => 'Mi primer post']);

        $response->assertRedirect('login');
    }

    /** @test */
    function an_authenticated_user_can_create_statuses()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.store'), ['body' => 'Mi primer post']);

        $response->assertJson([
            'body' => 'Mi primer post',
        ]);

        $this->assertDatabaseHas('statuses', [
            'user_id' => $user->id,
            'body' => 'Mi primer post'
        ]);
    }

    /** @test */
    function a_status_requires_a_body()
    {
        $this->actingAs(factory(User::class)->create());

        $response = $this->postJson(route('statuses.store'), ['body' => '']);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message', 'errors' => ['body']
        ]);
    }

    /** @test */
    function a_status_body_requires_a_minimum_length()
    {
        $this->actingAs(factory(User::class)->create());

        $response = $this->postJson(route('statuses.store'), ['body' => 'abcd']);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message', 'errors' => ['body']
        ]);
    }
}
