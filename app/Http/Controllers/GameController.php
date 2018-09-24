<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller
{
    //
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('game.index');
    }

    public function room(Request $request)
    {
        $input = $request->all();
        $roomOwner = $input['nickname'];
        $members[] = [$roomOwner, 1];

        $request->session()->put('member', $members);

        $rooms = [];
        if ($request->session()->has('rooms')) {
            $rooms = $request->session()->get('rooms');
        }
        
        do {
            $roomNumber = random_int(100, 999);    
        } while(in_array($roomNumber, $rooms));

        $rooms[] = $roomNumber;
        $request->session()->pull('rooms', $rooms);
        $request->session()->pull('roomNumber', $roomNumber);
        $request->session()->pull('roomOwner', $roomOwner);

        // return redirect('game/invite');
        return view('game.room', compact('roomOwner', 'roomNumber'));
    }

    public function entry(Request $request, $roomNumber)
    {
        $roomOwner = $request->session()->get('roomOwner');
        $roomNumber = $request->session()->get('roomNumber');

        return view('game.entry', compact('roomOwner', 'roomNumber'));
    }

    public function entryIn(Request $request)
    {
        $input = $request->all();
        $members[] = [$input['nickname'], 0];

        $request->session()->put('member', $members);

        $roomNumber = $request->session()->get('roomNumber');

        return redirect('game/show/'.$roomNumber);
        // return view('game.show', compact('roomOwner', 'trash1'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id=false)
    {
        $member = 4;
        $trash1 = '';

        if ($id) {
            $request->session()->forget('gameId');
            $request->session()->forget('memberCard');
            $request->session()->forget('trash1');
        }
        if ($request->session()->has('gameId')) {
            $id = $request->session()->get('gameId');
        } else {
            if (!$id) return redirect('game');
            $request->session()->put('gameId', $id);
        }

        if ($request->session()->has('memberCard')) {
            $memberCard = $request->session()->get('memberCard');
        } else {
        
            // c -> d -> h -> s -> jocker
            $cardTotal = (13 * 4) + 1;

            $type = ['c', 'd', 'h', 's'];
            foreach($type as $t) {
                foreach(range(1, 13) as $number) {
                    $card[] = $t.sprintf('%02d', $number);
                }
            }
            $card[] = 'x01';

            $num = 1;
            $memberCard = [];

            for($i=1; $i<=$cardTotal; $i++) {
                if ($num <= $member) {
                    $ret = array_rand($card);
                    $memberCard[$num][] = $card[$ret];
                    unset($card[$ret]);
                    if ($num == $member) {
                        $num = 1;
                    } else {
                        $num++;
                    }
                }
            }

            $request->session()->put('memberCard', $memberCard);
        }

        if ($request->session()->has('trash1')) {
            $trash1 = $request->session()->get('trash1');
        }

        return view('game.show', compact('memberCard', 'trash1'));
    }

    public function pull(Request $request, $card)
    {
        $trash1 = '';

        $input = $request->all();
        $memberCard = $request->session()->get('memberCard');

        $key = array_search($card, $memberCard[1]);
        unset($memberCard[1][$key]);
        $memberCard[2][] = $card;

        $request->session()->put('memberCard', $memberCard);

        return redirect('game/show');
        // return view('game.show', compact('memberCard'));
    }

    public function trash(Request $request, $card)
    {
        $trash1 = '';

        $input = $request->all();
        $memberCard = $request->session()->get('memberCard');

        if ($request->session()->has('trash1')) {
            $trash1 = $request->session()->get('trash1');
            if ($trash1 != $card) {
                if (substr($trash1, 1) == substr($card, 1)) {
                    $key1 = array_search($card, $memberCard[2]);
                    $key2 = array_search($trash1, $memberCard[2]);
                    unset($memberCard[2][$key1]);
                    unset($memberCard[2][$key2]);
                    $request->session()->put('memberCard', $memberCard);
                }
            }
            $request->session()->forget('trash1');
        } else {
            $request->session()->put('trash1', $card);
            $trash1 = $card;
        }

        return redirect('game/show');
        // return view('game.show', compact('memberCard', 'trash1'));
    }
}
