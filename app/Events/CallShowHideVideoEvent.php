<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CallShowHideVideoEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;

    public function __construct(CallShowHideVideoEventData $data)
    {
        $this->data = $data;
    }

    public function broadcastOn()
    {
        $channel = "call-show-hide-video-{$this->data->call}";

        return [ $channel ];
    }

    public function broadcastAs() {
        return 'call-show-hide-video';
    }
}
