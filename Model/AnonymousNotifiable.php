<?php


namespace Vibbe\Notification\Model;


use Vibbe\Notification\Interfaces\Notifiable;

class AnonymousNotifiable implements Notifiable
{
    public $routes = [];

    /**
     * Add routing information to the target.
     *
     * @param  string  $channel
     * @param  mixed  $route
     * @return $this
     */
    public function route($channel, $route)
    {
        $this->routes[$channel] = $route;

        return $this;
    }

    public function routeNotificationFor(string $channel)
    {
        return $this->routes[$channel] ?? null;
    }

}
