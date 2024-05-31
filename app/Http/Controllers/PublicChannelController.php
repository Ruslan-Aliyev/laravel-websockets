<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicChannelController extends Controller
{
    public function show()
    {
        return view('test-public');
    }

    public function test(Request $request)
    {
        $update = $request->input('update');
        event(new \App\Events\PublicChannelEvent($update));

        return redirect('/test-public-channel');
    }

    public function check()
    {
        return view('check-public');
    }
}
