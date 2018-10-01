<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CardChange implements ShouldBroadcast
{
    /**
     * 発送状態更新の情報
     *
     * @var string
     */
    public $update;

    /**
     * イベントをブロードキャストすべき、チャンネルの取得
     *
     * @return array
     */
    public function broadcastOn()
    {
        // return new PrivateChannel('order.'.$this->update->order_id);
        return new PrivateChannel('my-channel');
    }
    
    public function broadcastAs()
    {
        return "my-event";
    }

    public function broadcastWith()
    {
        return [
            'message' => 'Hello Pusher!!'
        ];
    }
}