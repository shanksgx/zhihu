<?php
/**
 * AnswerRepository
 *
 * @author xiaomo<momo_yx@qq.com>
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