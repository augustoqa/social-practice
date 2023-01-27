<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusCommentsController extends Controller
{
    public function store(Status $status)
    {
        Comment::create([
            'status_id' => $status->id,
            'user_id' => auth()->id(),
            'body' => request()->body,
        ]);
    }
}
