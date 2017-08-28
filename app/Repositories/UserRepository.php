<?php
/**
 * UserRepository
 *
 * @author xiaomo<momo_yx@qq.com>
 */

namespace App\Repositories;


use App\User;

class UserRepository
{
    public function byId($id)
    {
        return User::find($id);
    }
}