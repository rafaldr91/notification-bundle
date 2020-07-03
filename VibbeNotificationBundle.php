<?php

namespace Vibbe\Notification;


use Symfony\Component\HttpKernel\Bundle\Bundle;
use Vibbe\Notification\DependencyInjection\VibbeNotificationBundleExtension;

class VibbeNewsletterHelperBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new VibbeNotificationBundleExtension();
    }
}