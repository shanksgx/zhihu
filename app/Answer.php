<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    //
    protected $fillable = ['user_id', 'question_id', 'body'];

    /**
     * 多对一关联User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 多对一关联Question
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
