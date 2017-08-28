<?php

namespace App\Notifications;

use App\Channels\SendcloudChannel;
use Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Naux\Mail\SendCloudTemplate;
use Mail;

class NewUserFollowNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
//        return ['mail'];
        // 使用database方式进行通知/站内信
//        return ['database'];
        // 先调用database，再调用SendcloudChannel
        return ['database', SendcloudChannel::class];
    }

    /**
     * 使用Sendcloud发送通知
     *
     * @param $notifiable
     */
    public function toSendcloud($notifiable)
    {
        // 模板变量
        $data = [
            'url' => 'http://laravel.dev/notifications',
            'name' => Auth::guard('api')->user()->name
        ];
        // 传递模板和数据
        $template = new SendCloudTemplate('zhihu_new_user_follow', $data);
        // 发送邮件
        Mail::raw($template, function ($message) use ($notifiable) {
            $message->from('momo_yx@qq.com', '小莫');
            $message->to($notifiable->email);
        });
    }

    /**
     * 使用database方式进行通知
     *
     * @param $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        // 往notifications表中写入一条站内通知的消息
        return [
            'name' => Auth::guard('api')->user()->name,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
