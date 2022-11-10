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

        $response = $this->post(route('statuses.store'), ['body' => 'Mi primer post']);

        $response->assertJson([
            'body' => 'Mi primer post',
        ]);

        $this->assertDatabaseHas('statuses', [
            'user_id' => $user->id,
            'body' => 'Mi primer post'
        ]);
    }
}
