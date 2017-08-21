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
    // 获取请求当前api的用户数据
    $user = Auth::guard('api')->user();
    if ($user->followed($request->get('question'))) {
        return response()->json(['followed' => true]);
    }
    return response()->json(['followed' => false]);
})->middleware('auth:api');

// 修改用户关注问题的状态
Route::post('/question/follow', function (Request $request) {
    $user = Auth::guard('api')->user();
    $question = \App\Question::find($request->get('question'));
    // 修改状态
    $followed = $user->followThis($question->id);
    if (count($followed['detached']) > 0) {
        // 问题关注数-1
        $question->decrement('followers_count');
        return response()->json(['followed' => false]);
    }

    // 问题关注数+1
    $question->increment('followers_count');
    return response()->json(['followed' => true]);
})->middleware('auth:api');