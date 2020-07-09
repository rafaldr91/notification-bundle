<?php


namespace Vibbe\Notification\Interfaces;


interface Notifiable
{
    public function routeNotificationFor(string $channel);
}
