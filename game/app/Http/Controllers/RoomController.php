<?php

namespace App\Http\Controllers;

use App\Events\MyEvent;
use App\Events\SendMove;
use App\Events\StartEvent;
use App\Models\Active_Game;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

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
    public function joinRoom()
    {
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
            } else {
                return ($this->createRoom($id));
            }
        } else {
            return ($this->createRoom($id));
        }
    }
    public function createRoom($id)
    {
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
    public function sendMove(request $request)
    {
        if (Auth::id() == Active_Game::where('key', $request->key)->first()->user1) {
            $yourSymbol = 'X';
        } else {
            $yourSymbol = 'O';
        }
        event(new SendMove($request->key, $request->move, Auth::id(), $yourSymbol));
    }
    public function sendStartNotif(request $request)
    {
        event(new StartEvent($request->key));
    }
    public function sendReadyNotification(request $request)
    {
        $key = $request->key;
        if (!Schema::hasTable($key)) {
            Schema::create($key, function ($table) {
                $table->foreignId('user1')->nullable();
                $table->foreignId('user2')->nullable();
            });
            DB::table($key)->insert([
                'user1' => Auth::id()
            ]);
        }else {
            Schema::drop($key);
            event(new StartEvent($request->key));
        }
    }
}