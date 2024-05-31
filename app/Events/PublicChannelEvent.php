<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PublicChannelEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    var $updateInfo;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($updateInfo)
    {
        $this->updateInfo = $updateInfo;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('public.test-channel.1');
    }

    public function broadcastAs()
    {
        return 'PublicUpdateEvent';
    }

    public function broadcastWith()
    {
        return ['update' => $this->updateInfo];
    }
}
