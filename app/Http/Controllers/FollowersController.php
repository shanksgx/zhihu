<?php

namespace App\Http\Controllers;

use Auth;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class FollowersController extends Controller
{
    protected $user;

    /**
     * FollowersController constructor.
     * @param UserRepository $user
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }


    /**
     * 获取用户关注用户状态
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id)
    {
        // 登录者id
        $user = Auth::guard('api')->user();
        // 获取所有被登录者关注的id，pluck获取第一个followed_id
        $followers = $user->followers()->pluck('followed_id')->toArray();
        // 如果作者id在数组中则表示已关注
        if (in_array($id, $followers)) {
            return response()->json(['followed' => true]);
        }
        return response()->json(['followed' => false]);
    }

    /**
     * 修改用户关注用户状态
     */
    public function follow()
    {
        // 作者
        $userToFollow = $this->user->byId(request('user'));
        // 登录者
        $user = Auth::guard('api')->user();

        // 修改关注状态
        $followed = $user->followThisUser($userToFollow->id);
        // 关注则用户的关注数+1且作者的被关注数+1
        if (count($followed['attached']) > 0) {
            $user->increment('followings_count');   // 关注数+
            $userToFollow->increment('followers_count');    // 被关注数+1

            return response()->json(['followed' => true]);
        }

        // 用户的关注数-1且作者的被关注数-1
        $user->decrement('followings_count');
        $userToFollow->decrement('followers_count');

        return response()->json(['followed' => false]);
    }
}
