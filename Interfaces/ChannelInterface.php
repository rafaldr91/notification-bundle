<?php


namespace Vibbe\Notification\Interfaces;


use Vibbe\Notification\Model\NotificationModel;

interface ChannelInterface
{
    /**
     * @param $simpleMessage
     * @return mixed
     */
    public function notify($simpleMessage);

}
