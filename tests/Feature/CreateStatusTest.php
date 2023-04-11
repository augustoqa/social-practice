<?php

namespace Tests\Feature;

use Broadcast;
use App\User;
use Tests\TestCase;
use App\Events\StatusCreated;
use App\Http\Resources\StatusResource;
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CreateStatusTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guests_users_can_not_create_statuses() {
        $response = $this->postJson(route('statuses.store'), ['body' => 'Mi primer post']);

        $response->assertStatus(401);
    }

    /** @test */
    function an_authenticated_user_can_create_statuses()
    {
        Event::fake([StatusCreated::class]);
        
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.store'), ['body' => 'Mi primer post']);

        $response->assertJson([
            'data' => ['body' => 'Mi primer post'],
        ]);

        $this->assertDatabaseHas('statuses', [
            'user_id' => $user->id,
            'body' => 'Mi primer post'
        ]);
    }

    /** @test */
    function an_event_is_fired_when_a_status_is_created()
    {
        Event::fake([StatusCreated::class]);
        Broadcast::shouldReceive('socket')->andReturn('socket-id');

        $user = factory(User::class)->create();
        $this->actingAs($user)->postJson(route('statuses.store'), ['body' => 'Mi primer post']);

        Event::assertDispatched(StatusCreated::class, function ($createdEventStatus) {
            $this->assertInstanceOf(ShouldBroadcast::class, $createdEventStatus);
            $this->assertInstanceOf(StatusResource::class, $createdEventStatus->status);
            $this->assertInstanceOf(Status::class, $createdEventStatus->status->resource);
            $this->assertEquals($createdEventStatus->status->id, Status::first()->id);
            $this->assertEquals(
                'socket-id',
                $createdEventStatus->socket,
                'The event ' . get_class() . ' must call the method "dontBroadcastToCurrentUser" in the constructor.'
            );

            return true;
        });
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
