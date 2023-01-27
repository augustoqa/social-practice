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

        $this->actingAs($user)
            ->postJson(route('statuses.comments.store', $status), $comment);

        $this->assertDatabaseHas('comments', [
            'status_id' => $status->id,
            'user_id' => $user->id,
            'body' => $comment['body'],
        ]);
    }
}
