<?php

namespace Tests\Unit\Models;

use App\Models\Status;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function route_key_name_is_set_name()
    {
        $user = factory(User::class)->make();

        $this->assertEquals('name', $user->getRouteKeyName());
    }

    /** @test */
    function user_has_a_link_to_their_profile()
    {
        $user = factory(User::class)->make();

        $this->assertEquals(route('users.show', $user), $user->link());
    }

    /** @test */
    function user_has_an_avatar()
    {
        $user = factory(User::class)->make();

        $this->assertEquals('https://cdn-icons-png.flaticon.com/512/149/149071.png', $user->avatar());
        $this->assertEquals('https://cdn-icons-png.flaticon.com/512/149/149071.png', $user->avatar);
    }

    /** @test */
    function a_users_has_many_statuses()
    {
        $user = factory(User::class)->create();

        factory(Status::class)->create(['user_id' => $user->id]);

        $this->assertInstanceOf(Status::class, $user->statuses->first());
    }
}
