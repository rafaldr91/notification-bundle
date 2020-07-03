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

    /**
     * Call
     * @param $name
     * @param Notifiable $arguments
     */
    public function __call($name, $arguments)
    {
        $name = str_replace('to','',$name);
        $this->$this->channelMapper[$name]($arguments);
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

    /**
     * Override parameters like route
     *
     * @return array
     */
    public function getParametersToOverride(): array
    {
        return $this->parameters;
    }
}
