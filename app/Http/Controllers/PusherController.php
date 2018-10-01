<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\AccessDetection;
use App\Events\OrderShipped;
use App\Events\PullcardDetection;

use Illuminate\Support\Facades\Auth;

class PusherController extends Controller
{
    //
    public function events() {

        event(new AccessDetection(str_random(100)));

        return view('pusher3');
    }

    public function events2() {

        $user = Auth::user();
        event(new OrderShipped($user));

        return view('pusher2');
    }

    public function pullcard() {

        return view('pushercard');
    }

    public function pullcard2() {

        event(new PullcardDetection('h01'));


        return view('pushercard');
    }
    // pusher利用
    public function pusher() {

        // event(new PullcardDetection('h01'));

        return view('pusher');
    }
}
