<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    /**
     * 验证token
     *
     * @param $token
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function verify($token)
    {
        $user = User::where('confirmation_token', $token)->first();
        // 不存在则直接跳转回首页
        if (is_null($user)) {
            return redirect('/');
        }

        // 修改user数据
        $user->is_active = 1;   // 邮箱已激活
        $user->confirmation_token = str_random(40); // 修改token，防止重复
        $user->save();
        Auth::login($user); // 模拟登录
        return redirect('/home');
    }
}
