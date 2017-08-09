<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    //
    protected $fillable = ['name', 'bio', 'questions_count'];

    // 多对多关联
    public function questions()
    {
        // withTimestamps用来关联更新中间表的时间戳
        return $this->belongsToMany(Question::class)->withTimestamps();
    }
}
