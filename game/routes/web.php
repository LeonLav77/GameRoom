<?php

use Inertia\Inertia;
use App\Events\MyEvent;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\IndexController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group.s Now create something great!
|
*/
Route::view('/noAccess', 'noAccess');

Route::post('/yes', [RoomController::class, 'test']);

Route::post('/joinRoom', [RoomController::class, 'tryToJoinRoom']);

Route::group(['middleware' => ['protectedPage']], function () {
    Route::get('/', [IndexController::class,'index']);
});
require __DIR__.'/auth.php';