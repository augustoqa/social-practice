<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserResourceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_user_resources_must_have_the_necessary_fields()
    {
        $user = factory(User::class)->create();

        $userResource = UserResource::make($user)->resolve();

        $this->assertEquals($user->name, $userResource['name']);
        $this->assertEquals($user->link(), $userResource['link']);
        $this->assertEquals($user->avatar(), $userResource['avatar']);
    }
}
