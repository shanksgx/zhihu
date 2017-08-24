<?php
/**
 * UserRepository
 *
 * @author xiaomo<xiaomo@etlinker.com>
 * @copyright Copyright(C)2016 Wuhu Yichuan Network Technology Corporation Ltd. All rights reserved.
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