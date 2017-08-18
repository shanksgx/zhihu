<?php
/**
 * QuestionRepository
 *
 * @author xiaomo<xiaomo@etlinker.com>
 * @copyright Copyright(C)2016 Wuhu Yichuan Network Technology Corporation Ltd. All rights reserved.
 */

namespace App\Repositories;

use App\Question;
use App\Topic;


/**
 * 使用Repository作为控制器和模型的连接器，降低MC之间的耦合性
 *
 * Class QuestionRepository
 * @package App\Repositories
 */
class QuestionRepository
{
    public function getQuestionsFeed()
    {
        // 调用scopePublished
        return Question::published()->latest('updated_at')->with('user')->get();
    }

    /**
     * 根据id获取Question数据并关联获取Topic数据
     *
     * @param $id
     * @return mixed
     */
    public function byIdWithTopicsAndAnswers($id)
    {
        // 将模型的curd操作提取到Repository
        return Question::where('id', $id)->with(['topics', 'answers'])->first();
    }

    /**
     * 创建问题
     *
     * @param array $attributes
     * @return Question
     */
    public function create(array $attributes)
    {
        return Question::create($attributes);
    }

    /**
     * 根据id获取Question
     * @param $id
     * @return mixed
     */
    public function byId($id)
    {
        return Question::find($id);
    }

    /**
     * 整理Topic数组
     *
     * @param array $topics
     * @return array
     */
    public function normalizeTopic(array $topics)
    {
        return collect($topics)->map(function ($topic) {
            // questions_count+1
            if (is_numeric($topic)) {
                Topic::find($topic)->increment('questions_count');
                return (int)$topic;
            }

            // 插入新纪录，并获取id
            $newTopic = Topic::create(['name' => $topic, 'questions_count' => 1]);
            return $newTopic->id;
        })->toArray();
    }
}