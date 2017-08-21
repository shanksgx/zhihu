<?php

use Illuminate\Http\Request;

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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


// Topic API路由，根据q获取Topic
Route::get('/topics', function (Request $request) {
    $topics = \App\Topic::select(['id', 'name'])
        ->where('name', 'like', '%' . $request->query('q') . '%')
        ->get();
    return $topics;
})->middleware('api');


// 配合vue-resource实现ajax获取用户关注问题的状态
Route::post('/question/follower', function (Request $request) {
    $followed = \App\Follow::where('question_id', $request->get('question'))
        ->where('user_id', $request->get('user'))
        ->count();
    if ($followed) {
        return response()->json(['followed' => true]);
    }
    return response()->json(['followed' => false]);
})->middleware('api');

// 修改用户关注问题的状态
Route::post('/question/follow', function (Request $request) {
    $followed = \App\Follow::where('question_id', $request->get('question'))
        ->where('user_id', $request->get('user'))
        ->first();
    // 存在则删除记录
    if ($followed !== null) {
        $followed->delete();
        return response()->json(['followed' => false]);
    }

    // 插入一条新纪录
    \App\Follow::create([
        'question_id' => $request->get('question'),
        'user_id' => $request->get('user')
    ]);
    return response()->json(['followed' => true]);
})->middleware('api');