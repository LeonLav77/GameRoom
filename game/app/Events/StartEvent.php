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

class StartEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public string $key;
    public string $firstUserName;
    public string $secondUserName;
    public int $idFirstPlayer;
    public int $idSecondPlayer;

    public function __construct(string $key)
    {
        $this->key = $key;
        $firstUser = Active_Game::where('key', $this->key)->first()->player1;
        $secondUser = Active_Game::where('key', $this->key)->first()->player2;
        $this->idFirstPlayer = $firstUser->id;
        $this->idSecondPlayer = $secondUser->id;
        $this->firstUserName = $firstUser->name;
        $this->secondUserName = $secondUser->name;
    }
    public function broadcastWith()
    {
        return ['message'=> 'GAME STARTS', 'player1'=> $this->idFirstPlayer, 'player2'=> $this->idSecondPlayer,'player1Name' => $this->firstUserName,'player2Name' => $this->secondUserName];
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        event(new YourTurn($this->idFirstPlayer));
        event(new NotYourTurn($this->idSecondPlayer));
        return new Channel($this->key);
    }
}
