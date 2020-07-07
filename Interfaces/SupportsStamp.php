<?php


namespace Vibbe\Notification\Interfaces;


use Symfony\Component\Messenger\Stamp\StampInterface;

interface SupportsStamp
{
    /**
     * @return StampInterface[]
     */
    public function getStamps(): array;
}
