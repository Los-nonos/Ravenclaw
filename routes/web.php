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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/send', function () {
    Mail::send('email', [], function($message) {
        $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        $message->to('joaquinmartina44@gmail.com', 'joaquin martina')->subject('hola');
    });
    Mail::send('email', [], function($message) {
        $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        $message->to('martinmontanari3@gmail.com', 'Martin montanari')->subject('hola');
    });
    Mail::send('email', [], function($message) {
        $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        $message->to('ayrtoncravero26@gmail.com', 'Ayrton cravero')->subject('hola');
    });
    return 'correo enviado!';
});
