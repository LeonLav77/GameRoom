<?php

namespace App\Events;

use App\Models\Message;
use App\Events\YourTurn;
use App\Events\NotYourTurn;
use App\Models\Active_Game;
use Illuminate\Support\Facades\DB;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EventWon implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public string $key;
    public string $symbol;

    public function __construct(string $key,string $symbol)
    {
        $this->key = $key;
        $this->symbol = $symbol;
    }
    public function broadcastWith()
    {
        return ['message'=> 'GAME WON','winner' => $this->symbol];
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel($this->key);
    }
}