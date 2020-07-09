<?php


namespace Vibbe\Notification\Interfaces;


use Vibbe\Notification\Model\NotificationModel;

interface MessageProcessor
{
    /**
     * @param $message
     * @param NotificationModel $notificationContext
     * @param string $channelName
     * @return mixed
     */
    public function process($message,$notificationContext, string $channelName);
}
