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
    public $tableState;

    public function __construct(string $key, string $move, int $id, string $yourSymbol,$tableState)
    {
        $this->key = $key;
        $this->move = $move;
        $this->id = $id;
        $this->tableState = $tableState;
        $user1 = Active_Game::where('key', $this->key)->first()->user1;
        $user2 = Active_Game::where('key', $this->key)->first()->user2;
        $this->result = ($user1 == $this->id) ? $user2 : $user1;
        $this->yourSymbol = $yourSymbol;
        $this->logic = $this->symbolLogic($this->tableState,"X",$this->key);

    }

    public function broadcastWith()
    {

        return ['move' => $this->move,'symbol'=>$this->yourSymbol,'tableState'=>$this->tableState];
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
    public function symbolLogic($tableState,$symbol,$key){
        // PARALELNE
        if ($tableState[0] == $symbol && $tableState[1] == $symbol && $tableState[2] == $symbol) {
            return $this->callWin($key,$symbol);
        }
        else if ($tableState[3] == $symbol && $tableState[4] == $symbol && $tableState[5] == $symbol) {
            return $this->callWin($key,$symbol);
        }
        else if ($tableState[6] == $symbol && $tableState[7] == $symbol && $tableState[8] == $symbol) {
            return $this->callWin($key,$symbol);
        }
        // VERTIKALNE
        else if ($tableState[0] == $symbol && $tableState[3] == $symbol && $tableState[6] == $symbol) {
            return $this->callWin($key,$symbol);
        }
        else if ($tableState[1] == $symbol && $tableState[4] == $symbol && $tableState[7] == $symbol) {
            return $this->callWin($key,$symbol);
        }
        else if ($tableState[2] == $symbol && $tableState[5] == $symbol && $tableState[8] == $symbol) {
            return $this->callWin($key,$symbol);
        }
        else{
            return (json_encode($tableState));
        }
    }
    public function callWin($key,$symbol){

        event(new EventWon($key));
        return json_encode($symbol." WON");
    }
}