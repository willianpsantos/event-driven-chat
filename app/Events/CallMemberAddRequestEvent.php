<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CallMemberAddRequestEvent implements ShouldBroadcast
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
        $channel = "call-member-add-request-{$this->callId}";

        return [ $channel ];
    }

    public function broadcastAs() {
        return 'call-member-add-request';
    }
}
