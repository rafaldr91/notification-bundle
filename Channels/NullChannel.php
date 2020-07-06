<?php


namespace Vibbe\Notification\Channels;


use Vibbe\Notification\Interfaces\ChannelInterface;
use Vibbe\Notification\Interfaces\Notifiable;
use Vibbe\Notification\Model\NotificationModel;

class NullChannel implements ChannelInterface
{
    public function notify(Notifiable $notifiable, NotificationModel $notificationModel)
    {
        // TODO: Implement notify() method.
    }
}
