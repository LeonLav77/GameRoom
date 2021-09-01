<?php

namespace App\Http\Controllers;

use App\Events\MyEvent;
use App\Models\Active_Game;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class RoomController extends Controller
{
    public function test(request $request)
    {
        event(new MyEvent($request->message));
    }
    public function tryToJoinRoom()
    {
        $data = $this->checkIfRoomExists();
        event(new MyEvent($data));
        return(Active_Game::latest()->first()->key);
    }
    public function joinRoom(){
        Active_Game::latest()->first()->update(['user2' => Auth::id()]);
        Active_Game::latest()->first()->update(['status' => 'full']);
        event(new MyEvent('joined room'));

    }
    public function checkIfRoomExists()
    {
        $id = Auth::id();
        if (Active_Game::exists()) {
            if (Active_Game::latest()->first()->status == 'waiting') {
                $this->joinRoom();
                return("waiting");
            }else{
                return ($this->createRoom($id));
            }
        }else{
            return ($this->createRoom($id));
        }

    }
    public function createRoom($id){
            $key = Str::random(32);
            $room = new Active_Game([
                'key' => $key,
                'user1' => $id,
                'status' => 'waiting',
                'created_at' => now(),
            ]);
            $room->save();
            return("created");
    }
}
