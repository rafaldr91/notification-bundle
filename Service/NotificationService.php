<?php


namespace Vibbe\Notification\Service;


use Vibbe\Notification\Interfaces\MessageProcessor;
use Vibbe\Notification\Interfaces\Notifiable;
use Vibbe\Notification\Model\NotificationModel;

class NotificationService
{

    /** @var MessageProcessor */
    private $processor;

    /**
     * @param MessageProcessor $processor
     */
    public function setMessageProcessor($processor)
    {
        $this->processor = $processor;
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
                    $this->proceedMessage($message, $notificationModel, $viaChannel);
                   /* if($message instanceof SupportsStamp) {
                        $this->messageBus->dispatch($message,$message->getStamps());
                        continue;
                    }
                    $this->messageBus->dispatch($message);*/
                }
            }
        }

    }

    private function proceedMessage($message, $notificationModel, string $viaChannel)
    {
        $this->processor->process($message,$notificationModel,$viaChannel);
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

  /*  private function getChannel(string $name): ?AbstractChannel
    {
        return $this->availableChannels[$name] ?? null;
    }

    public function registerChannel(AbstractChannel $channel): self
    {
        $this->availableChannels[] = $channel;
        return $this;
    }

    public function getAvailableChannels(): array
    {
        return $this->availableChannels;
    }*/
}
