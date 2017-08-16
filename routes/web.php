<?php

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

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/', 'QuestionsController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');

// 邮箱验证
Route::get('email/verify/{token}', ['as' => 'email.verify', 'uses' => 'EmailController@verify']);

// Questions资源路由
Route::resource('questions', 'QuestionsController', ['names' => [
    'create' => 'question.create',
    'show' => 'question.show'
]]);