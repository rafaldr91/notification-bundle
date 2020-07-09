<?php


namespace Vibbe\Notification\Channels;



use Vibbe\Notification\Interfaces\ChannelInterface;

abstract class AbstractChannel implements ChannelInterface
{
    abstract function __invoke($message);
}
