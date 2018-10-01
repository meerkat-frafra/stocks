<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PusherEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($member)
    {
        //
        $this->member = $member;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // return new PrivateChannel('my-channel');
        return new Channel('my-channel');
        // return ['my-channel'];
    }

    public function broadcastAs() {
        return "my-trump1";
    }

    public function broadcastWith() {
        return [
            // 'member' => $this->member
            'message' => '1人入室しました！'
        ];
    }
}
