<?php

namespace App;

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
        'name', 'email', 'password', 'avatar', 'confirmation_token'
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
