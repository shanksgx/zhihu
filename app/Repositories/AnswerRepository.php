<?php
/**
 * AnswerRepository
 *
 * @author xiaomo<xiaomo@etlinker.com>
 * @copyright Copyright(C)2016 Wuhu Yichuan Network Technology Corporation Ltd. All rights reserved.
 */

namespace App\Repositories;


use App\Answer;

class AnswerRepository
{
    /**
     * 创建答案
     *
     * @param array $attributes
     * @return Answer
     */
    public function create(array $attributes)
    {
        return Answer::create($attributes);
    }
}