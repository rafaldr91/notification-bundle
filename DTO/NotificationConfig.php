<?php


namespace Vibbe\Notification\DTO;


class NotificationConfig
{
    protected $config = [];

    public function __construct()
    {
    }

    public function __get($name)
    {
        return $this->config[$name];
    }

    public function merge(array $data)
    {
        $this->config = array_merge($this->config,$data);
    }

    public function getRoute()
    {
        return $this->config['route'];
    }
}
