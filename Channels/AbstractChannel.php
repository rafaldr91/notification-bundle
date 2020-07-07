<?php


namespace Vibbe\Notification\Channels;


use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

abstract class AbstractChannel implements MessageHandlerInterface
{
    abstract function __invoke($message);
}
