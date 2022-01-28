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

Route::get('/soal-1', function () {
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

Route::get('/soal-2', function () {
    $input = "Saat meng*ecat tembok, Agung dib_antu oleh Raihan.";
    $input2 = "Kemarin Shopia per[gi ke mall.";
    $input3 = "Berapa u(mur minimal[ untuk !mengurus ktp?";

    function countWords($text) {
        $arr = explode(" ", $text);
    
        $temp = [];
        foreach($arr as $i => $val) {
            if(!hasSpecialChar($val)) $temp[] = $val;
        }

        print_r(count($temp));
    }

    function hasSpecialChar($my_string){
        $regex = preg_match('/[\'^£$%&*()}{@#~?!><>|=_+¬-]/', $my_string);
        if($regex) return true;
        else return false;
    }

    countWords($input2);
});