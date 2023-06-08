<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MemberDisconnectedOfCallEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $callId;
    public $member;

    public function __construct($callId, $member)
    {
        $this->callId = $callId;
        $this->member = $member;
    }

    public function broadcastOn()
    {
        $channel = "member-disconnected-of-call-{$this->callId}";

        return [ $channel ];
    }

    public function broadcastAs() {
        return 'member-disconnected-of-call';
    }
}
