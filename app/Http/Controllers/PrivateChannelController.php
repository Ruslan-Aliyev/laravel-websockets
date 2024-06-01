<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrivateChannelController extends Controller
{
    public function show()
    {
        return view('test-private');
    }

    public function test(Request $request)
    {
        $message = $request->input('message');
        event(new \App\Events\PrivateChannelEvent($message));

        return redirect('/test-private-channel');
    }

    public function check()
    {
        return view('check-private');
    }
}
