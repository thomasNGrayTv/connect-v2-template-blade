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
//set user info from GAUTH package middleware or api endpoint that gets user info 
//this is just example mock data
$user = [
    'firstName' => 'Thomas',
    'lastName' => 'Nixon',
    'allowed_stations' => ['GDM', 'CORP', 'WAFF'],
    'station' => 'GDM'
];

Route::get('/', function () use($user) {
    return view('welcome', ['user' => $user]);
});

Route::any('/{any}', function() use($user) {
    return view('welcome', ['user' => $user]);
})->where('any', '.*');
