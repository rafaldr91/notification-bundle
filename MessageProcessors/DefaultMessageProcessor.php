<?php


namespace Vibbe\Notification\MessageProcessors;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Vibbe\Notification\Interfaces\ChannelInterface;
use Vibbe\Notification\Interfaces\MessageProcessor;
use Vibbe\Notification\Model\NotificationModel;

class DefaultMessageProcessor implements MessageProcessor
{
    /**
     * @var ChannelInterface
     */
    private $channels = [];

    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function process($message, $notificationContext, string $viaChannel)
    {
        if(isset($this->channels[$viaChannel])) {
            $channel = $this->channels[$viaChannel];
            $channel($message);
        }
    }

    public function registerChannel(string $channelName, $channel)
    {
        $this->channels[$channelName] = $channel;
    }
}
