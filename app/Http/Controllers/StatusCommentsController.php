<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Events\CommentCreated;
use App\Models\Comment;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusCommentsController extends Controller
{
    public function store(Status $status)
    {
        request()->validate([
            'body' => 'required',
        ]);

        $comment = Comment::create([
            'status_id' => $status->id,
            'user_id' => auth()->id(),
            'body' => request()->body,
        ]);

        $commentResource = CommentResource::make($comment);

        CommentCreated::dispatch($commentResource);

        return $commentResource;
    }
}
