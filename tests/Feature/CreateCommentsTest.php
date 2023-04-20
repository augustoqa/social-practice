<?php

namespace Tests\Feature;

use App\Events\CommentCreated;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Status;
use App\User;
use Broadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CreateCommentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guest_users_cannot_create_comments()
    {
        $status = factory(Status::class)->create();
        $comment = ['body' => 'Mi primer comentario'];

        $response = $this->postJson(route('statuses.comments.store', $status), $comment);

        $response->assertStatus(401);
    }

    /** @test */
    function authenticated_users_can_comments_statuses()
    {
        $this->withoutExceptionHandling();
        
        $user = factory(User::class)->create();
        $status = factory(Status::class)->create();
        $comment = ['body' => 'Mi primer comentario'];

        $response = $this->actingAs($user)
            ->postJson(route('statuses.comments.store', $status), $comment);

        $response->assertJson([
            'data' => ['body' => $comment['body']]
        ]);

        $this->assertDatabaseHas('comments', [
            'status_id' => $status->id,
            'user_id' => $user->id,
            'body' => $comment['body'],
        ]);
    }

    /** @test */
    function an_event_is_fired_when_a_comment_is_created()
    {
        Event::fake([CommentCreated::class]);
        Broadcast::shouldReceive('socket')->andReturn('socket-id');

        $user = factory(User::class)->create();
        $status = factory(Status::class)->create();
        $comment = ['body' => 'Mi primer comentario'];

        $response = $this->actingAs($user)
            ->postJson(route('statuses.comments.store', $status), $comment);

        Event::assertDispatched(CommentCreated::class, function ($commentStatusEvent) {
            $this->assertInstanceOf(ShouldBroadcast::class, $commentStatusEvent);
            $this->assertInstanceOf(CommentResource::class, $commentStatusEvent->comment);
            $this->assertInstanceOf(Comment::class, $commentStatusEvent->comment->resource);
            $this->assertEquals(Comment::first()->id, $commentStatusEvent->comment->id);
            $this->assertEquals(
                'socket-id',
                $commentStatusEvent->socket,
                'The event ' . get_class($commentStatusEvent) . ' must call the method "dontBroadcastToCurrentUser" in the constructor.'
            );

            return true;
        });
    }

    /** @test */
    function a_comment_requires_a_body()
    {
        $this->actingAs(factory(User::class)->create());
        $status = factory(Status::class)->create();

        $response = $this->postJson(route('statuses.comments.store', $status), ['body' => '']);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message', 'errors' => ['body']
        ]);
    }
}
