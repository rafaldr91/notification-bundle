<?php


namespace Vibbe\Notification\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('vibbe_notification_bundle');

        $treeBuilder
            ->getRootNode()
                ->children()
                    ->scalarNode('transport_processor')
                        ->defaultValue('vibbe.notifications.processor')
                    ->end()
                ->end()
            ->end();


        return $treeBuilder;
    }

}
