<?php


namespace Vibbe\Notification\MessageProcessors;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
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
     * @var EventDispatcher
     */
    private $eventDispatcher;

    public function __construct(EventDispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function process($message, $notificationContext, string $viaChannel)
    {
        $this->eventDispatcher->dispatch($message);
    }
}
