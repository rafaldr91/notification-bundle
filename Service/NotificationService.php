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
     * @param Notifiable|Notifiable[] $notifiable
     *
     * @return mixed
     */
    public function send($notifications, $viaChannels, $notifiable)
    {
        $notifications = (is_array($notifications)) ? $notifications: [$notifications];
        $viaChannels   = (is_array($viaChannels)) ? $viaChannels : [$viaChannels];
        $notifiable    = (is_array($notifiable)) ? $notifiable : [$notifiable];

        /** @var NotificationModel $notificationModel */
        foreach ($notifications as $notificationModel) {
            foreach ($viaChannels as $viaChannel) {
                if(!$notificationModel->isSupportChannelMapper($viaChannel))
                {
                    continue;
                }

                $channelInstance = $this->getChannel($viaChannel);
                $messages = $this->prepareMessages($notificationModel,$notifiable,$this->getTransformerHandlerName($viaChannel));

                foreach ($messages as $message) {
                    $channelInstance->notify($message);
                }

            }
        }

    }

    /**
     * @param NotificationModel $notificationModel
     * @param Notifiable[] $notifiableArray
     * @param string
     * @return mixed[] $messages
     */
    private function prepareMessages(NotificationModel $notificationModel, &$notifiableArray, string $transformerName): array
    {
        $messages = [];
        foreach ($notifiableArray as $notifiable) {
            $messages[] = $notificationModel->{$transformerName}($notifiable);
        }
        return $messages;
    }

    private function getTransformerHandlerName(string $channelName): string
    {
        return 'to'.ucfirst($channelName);
    }

    private function getChannel(string $name): ChannelInterface
    {
        return $this->availableChannels[$name] ?? new NullChannel();
    }

    public function registerChannel(string $name, ChannelInterface $channel): self
    {
        $this->availableChannels[$name] = $channel;
    }

    public function getAvailableChannels(): array
    {
        return $this->availableChannels;
    }
}
