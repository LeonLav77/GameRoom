<?php

namespace App\Http\Controllers;

use App\Models\Active_Game;
use App\Events\GameRoomJoin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index(){
        return view('index');
    }
    public function gameRoom($key){
        $user = Auth::user();
        if($user->id == (Active_Game::where('key', $key)->select('user1')->get())[0]->user1){
            $user2 = Active_Game::where('key', $key)->first()->player2;
        }else{
            $user2 = Active_Game::where('key', $key)->first()->player1;
        }
        event(new GameRoomJoin($key,$user->name));
        return view('gameRoom',['key'=>$key,'player1' => $user->name, 'player2' => $user2->name]);
    }
}