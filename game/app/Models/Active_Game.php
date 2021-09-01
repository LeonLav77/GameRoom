<?php

namespace App\Models;

use Spatie\ModelStatus\HasStatuses;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Active_Game extends Model
{
    use HasFactory;
    public $table = 'active_games';
    protected $fillable = [
        'id',
        'key',
        'status',
        'user1',
        'user2',
        'created_at',
        'updated_at',
    ];

    public function player1(){
        return $this->belongsTo(User::class,'user1','id');
    }
    public function player2(){
        return $this->belongsTo(User::class,'user2','id');
    }

}