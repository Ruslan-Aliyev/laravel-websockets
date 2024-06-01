<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PresenceChannelEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    var $messageInfo;
    var $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($messageInfo, $user)
    {
        $this->messageInfo = $messageInfo;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('presence.test-channel.1');
    }

    public function broadcastAs()
    {
        return 'PresenceChatEvent';
    }

    public function broadcastWith()
    {
        return ['message' => $this->messageInfo, 'sender' => $this->user->name];
    }
}
