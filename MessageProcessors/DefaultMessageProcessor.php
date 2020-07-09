<?php


namespace Vibbe\Notification\MessageProcessors;


use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Vibbe\Notification\Interfaces\MessageProcessor;

class DefaultMessageProcessor implements MessageProcessor
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function process($message, $notificationContext, string $viaChannel)
    {
        $this->eventDispatcher->dispatch($message);
    }
}
