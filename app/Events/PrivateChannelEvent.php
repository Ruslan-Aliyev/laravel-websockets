<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PrivateChannelEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    var $messageInfo;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($messageInfo)
    {
        $this->messageInfo = $messageInfo;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('private.test-channel.1');
    }

    public function broadcastAs()
    {
        return 'PrivateMessageEvent';
    }

    public function broadcastWith()
    {
        return ['message' => $this->messageInfo];
    }
}
