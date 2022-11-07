<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateStatusTest extends TestCase
{
    /** @test */
    function an_authenticated_user_can_create_statuses()
    {
        $this->actingAs(factory(User::class)->create());

        $this->post(route('statuses.store'), ['body' => 'Mi primer post']);

        $this->assertDatabaseHas('statuses', [
            'body' => 'Mi primer post'
        ]);
    }
}
