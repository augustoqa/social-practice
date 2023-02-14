<?php

namespace Tests\Feature;

use App\Models\Status;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
