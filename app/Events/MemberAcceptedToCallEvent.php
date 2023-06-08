<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MemberAcceptedToCallEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $member;

    public function __construct($member)
    {
        $this->member = $member;
    }

    public function broadcastOn()
    {
        $channel = "member-accepted-rejected-to-call-{$this->member->id}";

        return [ $channel ];
    }

    public function broadcastAs() {
        return 'member-accepted-to-call';
    }
}
