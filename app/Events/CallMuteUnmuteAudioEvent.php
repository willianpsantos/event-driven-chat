<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;


class CallMuteUnmuteAudioEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;

    public function __construct(CallMuteUnmuteAudioEventData $data)
    {
        $this->data = $data;
    }

    public function broadcastOn()
    {
        $channel = "call-mute-unmute-audio-{$this->data->call}";

        return [ $channel ];
    }

    public function broadcastAs() {
        return 'call-mute-unmute-audio';
    }
}
