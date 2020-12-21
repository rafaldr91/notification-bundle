<?php


namespace Vibbe\Notification\MessageProcessors;


use Carbon\Carbon;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DelayStamp;
use Vibbe\Notification\Interfaces\MessageProcessor;
use Vibbe\Notification\Interfaces\ScheduledNotification;

class BusMessageProcessor implements MessageProcessor
{
    private $bus;
    private $defaultMessageProcessor;

    public function __construct(DefaultMessageProcessor $defaultMessageProcessor,
                                MessageBusInterface $bus)
    {
        $this->bus = $bus;
        $this->defaultMessageProcessor = $defaultMessageProcessor;
    }

    public function process($message, $notificationContext, string $channelSlug)
    {

        if($notificationContext instanceof ScheduledNotification) {
            $stamps = $notificationContext->getStamps();

            $stamp = null;
            if(isset($stamps[$channelSlug])) {
                $stamp = $stamps[$channelSlug];
            }

            if(isset($stamps['_all_'])) {
                $stamp = $stamps['_all_'];
            }

            if(!empty($stamp)) {
                $now = Carbon::now();
                $diff = $now->diffInMilliseconds($stamp);

                $this->bus->dispatch($message,[
                    new DelayStamp($diff)
                ]);
                return;
            }
        }

        $this->bus->dispatch($message);
        return;

    }
}
