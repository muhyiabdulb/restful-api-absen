<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    $socs = [5,7,7,9,10,4,5,10,6,5];
    $socs2 = [6,5,2,3,5,2,2,1,1,5,1,3,3,3,5];
    $socs3 = [1,1,3,1,2,1,3,3,3,3];
    
    function findPair($arr) {
        $temp = [];
        foreach(array_count_values($arr) as $val => $c) {
            if($c / 2 >= 2) {
                $temp[] = $val;
            }
            if($c > 1) $temp[] = $val;
        }
        print_r(count($temp));
    }
    
    findPair($socs3);
});