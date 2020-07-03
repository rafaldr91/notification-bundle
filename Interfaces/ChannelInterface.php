<?php


namespace Vibbe\Notification\Interfaces;


use Vibbe\Notification\Model\NotificationModel;

interface ChannelInterface
{
    public function alias():string;

    public function notify(Notifiable $notifiable, NotificationModel $notificationModel);

}
