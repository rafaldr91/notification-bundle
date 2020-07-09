<?php


namespace Vibbe\Notification\MessageProcessors;


use Symfony\Component\EventDispatcher\EventDispatcher;
use Vibbe\Notification\Interfaces\MessageProcessor;

class DefaultMessageProcessor implements MessageProcessor
{
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
