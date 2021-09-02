<?php

namespace App\Events;

use App\Models\Message;
use App\Events\YourTurn;
use App\Models\Active_Game;
use Illuminate\Support\Facades\DB;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendMove implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public string $key;
    public string $move;
    public string $id;
    public string $yourSymbol;
    public int $result;

    public function __construct(string $key, string $move, int $id, string $yourSymbol)
    {
        $this->key = $key;
        $this->move = $move;
        $this->id = $id;
        $user1 = Active_Game::where('key', $this->key)->first()->user1;
        $user2 = Active_Game::where('key', $this->key)->first()->user2;
        $this->result = ($user1 == $this->id) ? $user2 : $user1;
        $this->yourSymbol = $yourSymbol;
    }
    public function broadcastWith()
    {

        return ['move' => $this->move,'symbol'=>$this->yourSymbol];
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        event(new YourTurn($this->result));
        return new Channel($this->key);
    }
}