<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class QuestionFollowController extends Controller
{
    /**
     * 用户关注问题
     *
     * @param integer $question question_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function follow($question)
    {
        Auth::user()->follows($question);
        return back();
    }
}
