<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    protected $fillable = ['title', 'body', 'user_id'];

    /**
     * 多对多关联Topic
     */
    public function topics()
    {
        return $this->belongsToMany(Topic::class)->withTimestamps();
    }


    /**
     * 多对一关联User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 一对多关联Answer
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }


    /**
     * 使用queryScope提取查询条件
     *
     * @param $query
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where('is_hidden', 'F');
    }
}
