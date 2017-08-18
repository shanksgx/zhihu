<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class QuestionFollowController extends Controller
{
    /**
     * QuestionFollowController constructor.
     */
    public function __construct()
    {
        // 登录后才可以访问
        $this->middleware('auth');
    }

    /**
     * 用户关注问题
     *
     * @param integer $question question_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function follow($question)
    {
        Auth::user()->followThis($question);
        return back();
    }
}
