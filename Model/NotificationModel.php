<?php


namespace Vibbe\Notification\Model;


use Vibbe\Notification\Interfaces\Notifiable;
use Vibbe\Notification\Interfaces\NotificationInterface;

class NotificationModel implements NotificationInterface
{
    /**
     * Map channel name to method
     *
     * @var array
     */
    protected $channelMapper = [];

    protected $parameters = [];

    public $disabledChannels = [];

    protected $locale;

    /**
     * Call
     * @param $name
     * @param Notifiable $notifiable
     */
    public function __call($name, $notifiable)
    {
        $name = str_replace('to','',$name);
        $this->$this->channelMapper[$name]($notifiable);
    }

    public function isSupportChannelMapper(string $name): bool
    {
        return isset($this->channelMapper[$name]);
    }

    /**
     * When you wont to send notification to not notifiable entity
     *
     * @param string $channelName
     * @param        $route
     * @return $this
     */
    public function route(string $channelName, $route): self
    {
        $this->parameters[$channelName]['route'] = $route;
        return $this;
    }

    public function locale(string $locale):self
    {
        $this->locale = $locale;
        return $this;
    }

    /**
     * Override parameters like route
     *
     * @return array
     */
    public function getParametersToOverride(): array
    {
        return $this->parameters;
    }

    public function overrideParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }

    public function dontSendVia($channelName): self
    {
        $channelName = (is_array($channelName)) ? $channelName : [$channelName];
        $this->disabledChannels = $channelName;

        return $this;
    }

    /**
     * @return string[]
     */
    final public function getSupportedChannels()
    {
        $methodNames = get_class_methods($this);
        $supportedChannels = [];
        foreach ($methodNames as $methodName) {
            if(substr( $methodName, 0, 2 ) == 'to') {
                $supportedChannels[] = strtolower(str_replace('to','',$methodName));
            }
        }
        return $supportedChannels;
    }
}
