<?php


namespace Vibbe\Notification\Service;


use Vibbe\Notification\Interfaces\MessageProcessor;
use Vibbe\Notification\Interfaces\Notifiable;
use Vibbe\Notification\Interfaces\NotificationServiceInterface;
use Vibbe\Notification\Model\AnonymousNotifiable;
use Vibbe\Notification\Model\NotificationModel;

class NotificationService implements NotificationServiceInterface
{
    private $filters = [];

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
     * @param Notifiable|Notifiable[]|null $notifiable
     *
     * @return mixed
     */
    public function send($notifications, $notifiable = null)
    {
        $notifications = (is_array($notifications)) ? $notifications: [$notifications];
        $notifiable    = (is_array($notifiable)) ? $notifiable : [$notifiable];

        /** @var NotificationModel $notificationModel */
        foreach ($notifications as $notificationModel) {
            $viaChannels = $notificationModel->getSupportedChannels();

            foreach ($viaChannels as $viaChannel) {
                if(in_array($viaChannel,$notificationModel->disabledChannels)) {
                    continue;
                }

                $messages = $this->prepareMessages($notificationModel,$notifiable,$this->getTransformerHandlerName($viaChannel), $viaChannel);
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

    private function proceedMessage($message, $notificationModel, string $channelSlug)
    {
        $this->processor->process($message,$notificationModel,$channelSlug);
    }

    /**
     * @param NotificationModel $notificationModel
     * @param Notifiable[] $notifiableArray
     * @param string
     * @param string $channelName
     * @return mixed[] $messages
     */
    private function prepareMessages(NotificationModel $notificationModel, &$notifiableArray, string $transformerName, string $channelName): array
    {
        $messages = [];
        if(empty($notifiableArray)) {
            $newNotifiable = $this->injectNotifiable($notificationModel,$channelName);
            return [$notificationModel->{$transformerName}($newNotifiable)];
        }

        foreach ($notifiableArray as $notifiable) {
            $newNotifiable = $this->injectNotifiable($notificationModel,$channelName);
            if($newNotifiable instanceof Notifiable){
                $messages[] = $notificationModel->{$transformerName}($newNotifiable);
            } else {
                $messages[] = $notificationModel->{$transformerName}($notifiable);
            }
        }
        return $messages;
    }

    private function injectNotifiable(NotificationModel $notificationModel, string $channelName): ?Notifiable
    {
        $parameters = $notificationModel->getParametersToOverride();
        if(isset($parameters[$channelName]['route'])) {
            $notifiable = new AnonymousNotifiable();
            $notifiable->route($channelName,$parameters[$channelName]['route']);
            return $notifiable;
        }
        return null;
    }

    private function getTransformerHandlerName(string $channelName): string
    {
        return 'to'.ucfirst($channelName);
    }



    public function addFilter($callable):self
    {
        $this->filters[] = $callable;
        return $this;
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
