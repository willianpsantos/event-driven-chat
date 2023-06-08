<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Notifications\Channels\BroadcastChannel;
use Illuminate\Queue\SerializesModels;

class ChatMessageSentEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $sesstoken;
    public $message;

    public function __construct($token, $message)
    {
        $this->sesstoken = $token;
        $this->message = $message;
    }

    public function broadcastOn()
    {
        $channel = "chat-message-sent-{$this->sesstoken}";

        return [ $channel ];
    }

    public function broadcastAs() {
        return "chat-message-sent";
    }
}
