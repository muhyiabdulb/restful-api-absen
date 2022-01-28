<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController; 
use App\Http\Controllers\API\SupervisorController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\EpresenceController; 

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//API route for register new user
Route::post('/register', [AuthController::class, 'register']);
//API route for login user
Route::post('/login', [AuthController::class, 'login']);

//Protecting Routes
Route::group(['middleware' => ['auth:sanctum']], function () {

    // route supervisor
    Route::prefix('supervisor')->name('supervisor.')->group(function (){        
        Route::get('/profile', [SupervisorController::class, 'profile'])->name('profile');

        Route::post('add-user', [SupervisorController::class, 'addUser'])->name('addUser');
        Route::get('get-user', [SupervisorController::class, 'getUser'])->name('getUser');
        Route::put('approve-user/{id}', [SupervisorController::class, 'approveUser'])->name('approveUser');
    });

    // route user
    Route::prefix('user')->name('user.')->group(function (){
        Route::get('/profile', [UserController::class, 'profile'])->name('profile');

        Route::post('add-present', [UserController::class, 'addPresent'])->name('addPresent');
        Route::get('get-present', [UserController::class, 'getPresent'])->name('getPresent');
    });

    // API route for logout user
    Route::post('/logout', [AuthController::class, 'logout']);
});