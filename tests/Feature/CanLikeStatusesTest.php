<?php

namespace Tests\Feature;

use App\Models\Status;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CanLikeStatusesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guests_users_can_not_like_statuses()
    {
        $status = factory(Status::class)->create();

        $response = $this->postJson(route('statuses.likes.store', $status));

        $response->assertStatus(401);
    }

    /** @test */
    function an_authenticated_user_can_like_statuses()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $status = factory(Status::class)->create();

        $this->actingAs($user)->postJson(route('statuses.likes.store', $status));

        $this->assertDatabaseHas('likes', [
            'status_id' => $status->id,
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    function an_authenticated_user_can_unlike_statuses()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $status = factory(Status::class)->create();

        $this->actingAs($user)->postJson(route('statuses.likes.store', $status));
        $this->actingAs($user)->deleteJson(route('statuses.likes.destroy', $status));

        $this->assertDatabaseMissing('likes', [
            'status_id' => $status->id,
            'user_id' => $user->id,
        ]);
    }
}