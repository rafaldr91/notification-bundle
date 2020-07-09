<?php


namespace Vibbe\Notification\MessageProcessors;


use Vibbe\Notification\Interfaces\ChannelInterface;
use Vibbe\Notification\Interfaces\MessageProcessor;
use Vibbe\Notification\Model\NotificationModel;

class DefaultMessageProcessor implements MessageProcessor
{
    /**
     * @var ChannelInterface
     */
    private $channels = [];

    public function process($message, $notificationContext, string $viaChannel)
    {
        if(isset($this->channels[$viaChannel])) {
            $channel = $this->channels[$viaChannel];
            $channel($message);
        }
    }

    public function registerChannel(string $channelName, $handler)
    {
        $this->channels[$channelName] = $handler;
    }
}
