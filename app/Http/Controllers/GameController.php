<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GameRoom;
use App\GameMember;

use Debugbar;

class GameController extends Controller
{

    public function __construct()
    {
        //
    }

    /**
     * 遊び場作成画面
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // セッションを全クリア
        session()->flush();

        return view('game.index');
    }

    /**
     * 遊び場作成
     *
     * @return \Illuminate\Http\Response
     */
    public function room(Request $request)
    {
        $input = $request->all();

        $owner = $input['owner'];
        $me = [0 => [$owner, 1, 1]]; // ニックネーム, オーナーフラグ, 順番

        // 遊び場登録
        $game_rooms = new GameRoom;
        $game_rooms->owner = $owner;
        $game_rooms->roomname = $owner.'さんのゲーム部屋';
        $game_rooms->target = 0; // 参加順でカードを引く
        $game_rooms->wait = 1;
        $game_rooms->save();
        
        $roomId = $game_rooms->id;
        // ルームIDをセッションに追加
        $request->session()->put('roomId', $roomId);

        // メンバー登録
        $game_members = new GameMember;
        $game_members->roomId = $roomId;
        $game_members->name =  $owner;
        $game_members->isOwner =  1;
        $game_members->sort = 0;
        $game_members->cards = '';
        $game_members->cardCount = 0;
        $game_members->save();

        $me = [
               'myMemberId' => $game_members->id, 
               'isOwner' => $game_members->isOwner
              ];

        // 自分のメンバーIdをセッションに追加
        $request->session()->put('me', $me);

        return redirect('game/ready/'.$roomId);
    }

    /**
     * 参加者一覧
     *
     * @return \Illuminate\Http\Response
     */
    public function ready(Request $request, $roomId)
    {
        $rooms = GameRoom::find($roomId);
        $members = GameMember::where('roomId', $roomId)->get();

        $me = $request->session()->get('me');

        return view('game.ready', compact('rooms', 'members', 'me'));
    }

    /**
     * 招待された人の初期ページ
     *
     * @return \Illuminate\Http\Response
     */
    public function entry(Request $request, $roomId)
    {
        // セッションを全クリア
        session()->flush();

        $game_rooms = GameRoom::find($roomId);
        if (!$game_rooms) abort(403);

        return view('game.entry', compact('game_rooms'));
    }

    /**
     * 招待された人の入室処理
     *
     * @return \Illuminate\Http\Response
     */
    public function entryin(Request $request)
    {
        $input = $request->all();
        if (!$input) abort(403);

        $roomId = $input['roomId'];
        $game_rooms = GameRoom::find($roomId);

        // ルームIDをセッションに追加
        $request->session()->put('roomId', $roomId);

        // メンバー登録
        $game_members = new GameMember;
        $game_members->roomId = $roomId;
        $game_members->name =  $input['nickname'];
        $game_members->isOwner =  0;
        $game_members->sort = 0;
        $game_members->cards = '';
        $game_members->cardCount = 0;
        $game_members->save();

        $me = [
               'myMemberId' => $game_members->id, 
               'isOwner' => $game_members->isOwner
              ];

        // 自分のメンバーIdをセッションに追加
        $request->session()->put('me', $me);

        event(new \App\Events\PusherEvent($input['nickname']));

        return redirect('game/ready/'.$roomId);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $roomId=false)
    {
        $roomId = $request->session()->get('roomId');
        $me = $request->session()->get('me');
        $room = GameRoom::find($roomId);
        
        $members = GameMember::where('roomId', $roomId)->where('cards', '!=', 'a:0:{}')->get();
        $myCards = GameMember::where('roomId', $roomId)->where('id', $me['myMemberId'])->pluck('cards');
        
        $vsMemberId = '';
        $nextPerson = [];
        $next = false;
        foreach($members as $n => $member) {
            if ($n == 0) {
                $nextPerson = unserialize($member->cards);
                $vsMemberId = $member->id;
            }
            if ($next) {
                $nextPerson = unserialize($member->cards);
                $vsMemberId = $member->id;
                $next = false;
            }
            if ($member->id == $me['myMemberId']) {
                $next = true;
            }
        }

        if (!$request->session()->has('me.myCards')) {
            // 自分の配られたカードリストをセッションに追加
            $me['myCards'] = unserialize($myCards[0]);
            $me['vsMemberId'] = $vsMemberId; // 自分が引くカードを持つ相手
            // $me['vsMemberId'] = $vsMemberId; // 自分が引くカードを持つ相手
            $request->session()->put('me', $me);
        }

        $trash1 = '';

        if ($request->session()->has('trash1')) {
            $trash1 = $request->session()->get('trash1');
        }

        return view('game.show', compact('room', 'trash1', 'me', 'nextPerson'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function showroom(Request $request)
    {
        $roomId = $request->session()->get('roomId');
        
        $game_rooms = GameRoom::find($roomId);
        $members = GameMember::where('roomId', $roomId)->get();
        $memberCount = $members->count();

        // カードを配る
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
            if ($num <= $memberCount) {
                $ret = array_rand($card);
                $memberCard[$num][] = $card[$ret];
                unset($card[$ret]);
                if ($num == $memberCount) {
                    $num = 1;
                } else {
                    $num++;
                }
            }
        }  

        // 同じカードを削除
        // foreach($memberCard as $n => $cards) {
        //     foreach($cards as $card) {
        //         if ($card != 'x01') {

        //         }
        //         if (substr($trash1, 1) == substr($card, 1)) {
                    
        //             $key1 = array_search(substr($card, 1), $cards);
        //         }
        //     }
        // }

        foreach ($members as $n => $member) {
            $input = [];
            $input['sort'] = $memberCount - $n;
            $input['cards'] = serialize($memberCard[$n+1]);
            $input['cardCount'] = count($memberCard[$n+1]);
            GameMember::where('id', $member->id)->update($input);

            // 一番最後の人が準備できたら開始
            if ($n == 0) {
                GameRoom::where('id', $roomId)->update(['target' => $member->id]);
            }
            
        }

        event(new \App\Events\Pusher2Event('game start.'));

        return redirect('game/show/'.$roomId);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function showroom2(Request $request)
    {
        $roomId = $request->session()->get('roomId');
        return redirect('game/show/'.$roomId);
    }

    public function pull(Request $request, $card)
    {
        $trash1 = '';

        $input = $request->all();

        $roomId = $request->session()->get('roomId');
        $me = $request->session()->get('me');
        
        // 自分のカードに追加
        $game_member = GameMember::find($me['myMemberId']);
        $cards = unserialize($game_member->cards);
        $cards[] = $card;
        $me['myCards'] = $cards;
        $request->session()->put('me', $me);
        $cnt = count($cards);
        if (!$cnt) {
            dd('あなたの勝ち！');
        }
        GameMember::where('id', $me['myMemberId'])->update(['cards' => serialize($cards), 'cardCount' => $cnt]);
        

        // 相手のカードから除去
        $vsMember = GameMember::find($me['vsMemberId']);
        $vsMemberCard = unserialize($vsMember->cards);
        $key = array_search($card, $vsMemberCard);
        unset($vsMemberCard[$key]);
        $cnt = count($vsMemberCard);

        GameMember::where('id', $me['vsMemberId'])->update(['cards' => serialize($vsMemberCard), 'cardCount' => $cnt]);
        if (!$vsMemberCard) {
            dd('相手の負け');
        }

        // 待ち状態にする
        GameRoom::where('id', $roomId)->update(['wait' => 1]);

        return redirect('game/show');
    }

    public function oke(Request $request)
    {
        $roomId = $request->session()->get('roomId');
        $me = $request->session()->get('me');

        // カードを引き人を次に進める
        $members = GameMember::where('roomId', $roomId)->get();
        $next = false;
        foreach($members as $n => $member) {
            if ($n == 0) {
                $target = $member->id;
            }
            if ($next) {
                $target = $member->id;
                $next = false;
            }
            if ($member->id == $me['myMemberId']) {
                $next = true;
            }
        }

        GameRoom::where('id', $roomId)->update(['target' => $target]);
        // 待ち状態を解除する
        GameRoom::where('id', $roomId)->update(['wait' => 0]);

        event(new \App\Events\Pusher3Event());

        return redirect('game/show');
    }

    public function trash(Request $request, $card)
    {
        $trash1 = '';

        $input = $request->all();

        $me = $request->session()->get('me');
        $roomId = $request->session()->get('roomId');

        if ($request->session()->has('trash1')) {
            $trash1 = $request->session()->get('trash1');
            if ($trash1 != $card) {
                if (substr($trash1, 1) == substr($card, 1)) {
                    $key1 = array_search($card, $me['myCards']);
                    $key2 = array_search($trash1, $me['myCards']);
                    unset($me['myCards'][$key1]);
                    unset($me['myCards'][$key2]);
                    $request->session()->put('me', $me);

                    $input['cards'] = serialize($me['myCards']);
                    $input['cardCount'] = count($me['myCards']);

                    if (!$input['cardCount']) {
                        dd('あなたの勝ち');
                    }

                    GameMember::where('id', $me['myMemberId'])->update($input);
                }
            }
            $request->session()->forget('trash1');
        } else {
            $request->session()->put('trash1', $card);
            $trash1 = $card;
        }

        return redirect('game/show');
    }

}
