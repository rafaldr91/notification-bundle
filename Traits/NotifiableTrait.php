<?php


namespace Vibbe\Notification\Traits;


trait NotifiableTrait
{
    public function routeNotificationFor(string $driver) {
        if (method_exists($this, $method = 'routeNotificationFor'.ucfirst($driver))) {
            return $this->{$method}();
        }

        switch ($driver) {
            case 'mail':
                return $this->getEmail();
        }
    }
}
