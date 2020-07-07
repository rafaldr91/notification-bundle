<?php

namespace Vibbe\Notification;


use Symfony\Component\HttpKernel\Bundle\Bundle;
use Vibbe\Notification\DependencyInjection\VibbeNotificationBundleExtension;

class VibbeNotificationBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new VibbeNotificationBundleExtension();
    }
}
