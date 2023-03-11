<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\User;
use Illuminate\Http\Request;

class FriendshipsController extends Controller
{
    public function store(User $recipient)
    {
        Friendship::create([
            'sender_id' => auth()->id(),
            'recipient_id' => $recipient->id,
        ]);
    }
}