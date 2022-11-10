<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusesController extends Controller
{
    public function store(Request $request)
    {
        Status::create([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);
    }
}
