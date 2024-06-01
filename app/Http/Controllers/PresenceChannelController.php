<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresenceChannelController extends Controller
{
    public function show()
    {
        return view('chat-presense');
    }

    public function send(Request $request)
    {
        $message = $request->input('message');
        event(new \App\Events\PresenceChannelEvent($message, Auth::user()));
    }
}
