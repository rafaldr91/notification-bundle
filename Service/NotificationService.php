<?php


namespace Vibbe\Notification\Service;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Vibbe\Notification\Channels\AbstractChannel;
use Vibbe\Notification\Channels\NullChannel;
use Vibbe\Notification\Exceptions\ChannelNameIsReservedException;
use Vibbe\Notification\Interfaces\ChannelInterface;
use Vibbe\Notification\Interfaces\Notifiable;
use Vibbe\Notification\Interfaces\SupportsStamp;
use Vibbe\Notification\Model\NotificationModel;

class NotificationService
{
    /** @var AbstractChannel[] */
    protected $availableChannels = [];
    /**
     * @var MessageBusInterface
     */
    private $messageBus;
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(MessageBusInterface $messageBus, ContainerInterface $container)
    {
        $this->messageBus = $messageBus;
        $this->container = $container;
    }

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

                $messages = $this->prepareMessages($notificationModel,$notifiable,$this->getTransformerHandlerName($viaChannel));
                foreach ($messages as $message) {
                    if($message instanceof SupportsStamp) {
                        $this->messageBus->dispatch($message,$message->getStamps());
                        continue;
                    }
                    $this->messageBus->dispatch($message);
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

    private function getChannel(string $name): ?AbstractChannel
    {
        return $this->availableChannels[$name] ?? null;
    }

    public function registerChannel(string $name, AbstractChannel $channel): self
    {
        $this->availableChannels[$name] = $channel;
        if(isset($this->availableChannels[$name])) {
            throw new ChannelNameIsReservedException("Channel $name already exists");
        }

        return $this;
    }

    public function getAvailableChannels(): array
    {
        return $this->availableChannels;
    }
}
