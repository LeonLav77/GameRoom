<?php

namespace App\Models;

use Spatie\ModelStatus\HasStatuses;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Active_Game extends Model
{
    use HasStatuses;
    use HasFactory;
    public $table = 'active_games';
    protected $fillable = [
        'id',
        'key',
        'user1',
        'user2',
        'created_at',
        'updated_at',
    ];
}