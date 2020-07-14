<?php


namespace Vibbe\Notification\Interfaces;


use Vibbe\Notification\Model\NotificationModel;

interface NotificationServiceInterface
{
    public function send(NotificationModel $notificationModel, $notifiable = null);
}
