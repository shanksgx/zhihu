<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    /**
     * 通知消息列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        return view('notifications.index', compact('user'));
    }
}
