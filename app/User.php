<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Naux\Mail\SendCloudTemplate;
use Mail;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'confirmation_token', 'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 一对多关联Answer
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * 用户关注问题-多对多关联Question
     */
    public function follows()
    {
        return $this->belongsToMany(Question::class, 'user_question')->withTimestamps();
    }

    /**
     * 用户关注问题
     *
     * @param integer $question question_id
     * @return array
     */
    public function followThis($question)
    {
        // toggle=切换
        return $this->follows()->toggle($question);
    }

    /**
     * 获取关注状态
     *
     * @param integer $question question_id
     * @return bool
     */
    public function followed($question)
    {
        // !!强制转换为bool类型
        return !!$this->follows()->where('question_id', $question)->count();
    }

    /**
     * 用户关注用户-多对多关联User
     */
    public function followers()
    {
        return $this->belongsToMany(self::class, 'followers', 'follower_id', 'followed_id')->withTimestamps();
    }

    /**
     * 用户关注用户
     *
     * @param $user
     * @return array
     */
    public function followThisUser($user)
    {
        return $this->followers()->toggle($user);
    }

    /**
     * 判断身份是否是当前登录id
     *
     * @param Model $model
     * @return bool
     */
    public function owns(Model $model)
    {
        return $this->id == $model->user_id;
    }

    /**
     * 重写发送密码重置邮件的提醒方法
     *
     * @param  string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        // 模板变量
        $data = [
            'url' => url('password/reset', $token),
        ];
        // 传递模板和数据
        $template = new SendCloudTemplate('zhihu_password_reset', $data);
        // 发送邮件
        Mail::raw($template, function ($message) {
            $message->from('momo_yx@qq.com', '小莫');
            $message->to($this->email);
        });
    }
}
