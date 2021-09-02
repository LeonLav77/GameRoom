<?php

namespace App\Http\Controllers;

use App\Events\EventWon;
use Illuminate\Http\Request;

class LogicController extends Controller
{
    public function logic(Request $request){
        $tableState = $request->tableState;
        $key = $request->key;
        $this->symbolLogic($tableState,"X",$key);
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