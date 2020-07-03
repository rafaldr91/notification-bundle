<?php


namespace Vibbe\Notification\Service;


use Vibbe\Notification\Channels\NullChannel;
use Vibbe\Notification\Interfaces\ChannelInterface;
use Vibbe\Notification\Interfaces\Notifiable;
use Vibbe\Notification\Model\NotificationModel;

class NotificationService
{
    /** @var ChannelInterface[] */
    protected $availableChannels = [];

    /**
     * @param NotificationModel|NotificationModel[] $notifications
     * @param string|string[] $viaChannels
     * @param Notifiable $notifiable
     */
    public function send($notifications, $viaChannels, Notifiable $notifiable){
        $notifications = (is_array($notifications)) ? $notifications: [$notifications];
        $viaChannels = (is_array($viaChannels)) ? $viaChannels : [$viaChannels];

        foreach ($viaChannels as $viaChannel) {
            $channelInstance = $this->getChannel($viaChannel);
            $channelInstance->notify($notifiable,$notifications);
        }
    }

    private function getChannel(string $name): ChannelInterface
    {
        return $this->availableChannels[$name] ?? new NullChannel();
    }

    public function addChannel(string $name, ChannelInterface $channel)
    {
        $this->availableChannels[$name] = $channel;
    }

    public function getAvailableChannels(): array
    {
        return $this->availableChannels;
    }
}
