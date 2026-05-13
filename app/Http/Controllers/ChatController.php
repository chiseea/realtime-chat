<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\MessageSent;

class ChatController extends Controller
{
    public function index()
    {
        $messages = Message::oldest()->get();

        return view('chat', compact('messages'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'user' => 'required',
            'message' => 'required'
        ]);

        $message = Message::create([
            'user' => $request->user,
            'message' => $request->message
        ]);

        broadcast(new MessageSent($message));

        return response()->json([
            'success' => true
        ]);
    }
}
