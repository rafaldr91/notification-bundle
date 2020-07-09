<?php


namespace Vibbe\Notification\Interfaces;


use Vibbe\Notification\Model\NotificationModel;

interface ChannelInterface
{
    public function __invoke($message);
}
