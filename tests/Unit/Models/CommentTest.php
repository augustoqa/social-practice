<?php

namespace Tests\Unit\Models;

use App\Models\Comment;
use App\Traits\HasLikes;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_comment_belongs_to_a_user()
    {
        $comment = factory(Comment::class)->create();

        $this->assertInstanceOf(User::class, $comment->user);
    }

    /** @test */
    function a_comment_model_must_use_the_trait_has_likes()
    {
        $this->assertClassUsesTrait(HasLikes::class, Comment::class);
    }
}
