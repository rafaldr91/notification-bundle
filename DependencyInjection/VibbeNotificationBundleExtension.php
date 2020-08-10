<?php


namespace Vibbe\Notification\DependencyInjection;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class VibbeNotificationBundleExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration,$configs);

        $container->setParameter('vibbe_notification_bundle.transport_processor', $config['swift_mailer_service'] ?? 'vibbe.notifications.processor');

        $loader->load('services.yaml');
    }

}
