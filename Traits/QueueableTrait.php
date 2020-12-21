<?php
/**
 * Created by Vibbe.
 * User: Rafał Drożdżal (rafal@vibbe.pl)
 * Date: 18.12.2020
 */

namespace Vibbe\Notification\Traits;


class QueueableTrait
{
    protected $stamps = [];

    /**
     * @param string|string[] $channels chose what channels must be delayed
     * @param int|string|\DateTimeInterface $time
     * @return $this
     */
    public function delay($time,array $channels = null): self
    {
        if(!empty($channels)) {
            if(is_string($channels)) {
                $channels = [$channels];
            }
        }

        if($time instanceof \DateTimeInterface) {
            $this->addStamp($channels,$time);
        }
        if(is_string($time)) {
            $this->addStamp($channels, new \DateTime($time));
        }
        if(is_integer($time)) {
            $sendAfter = new \DateTime('now');
            $sendAfter->add(new \DateInterval('PT'.$time.'M'));
            $this->addStamp($channels, $sendAfter);
        }

        return $this;
    }

    private function addStamp(?array $channels, \DateTimeInterface $dateTime)
    {
        if(empty($channels)) {
            $this->stamps['_all_'] = $dateTime;
            return;
        }

        foreach ($channels as $channel) {
            $this->stamps[$channel] = $dateTime;
        }
        return;
    }

    public function getStamps()
    {
        return $this->stamps;
    }

}