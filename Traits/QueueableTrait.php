<?php


namespace Vibbe\Notification\Traits;


use Symfony\Component\Messenger\Stamp\DelayStamp;

trait StampTrait
{
    protected $stamps = [];

    /**
     * @param int $time Time in ms
     * @return $this
     */
    public function delay($time): self
    {
        $this->stamps[] = new DelayStamp($time);
    }
}
