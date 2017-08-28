<?php
/**
 * 自定义SendcloudChannel
 *
 * @author xiaomo<momo_yx@qq.com>
 */

namespace App\Channels;


use Illuminate\Notifications\Notification;

class SendcloudChannel
{
    /**
     * 发送邮件
     *
     * @param $notifiable
     * @param Notification $notification
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSendcloud($notifiable);
    }
}