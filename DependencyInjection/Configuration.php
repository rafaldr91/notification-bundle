<?php


namespace Vibbe\Notification\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('vibbe_notification');

        $treeBuilder
            ->getRootNode()
                ->children()
                    ->scalarNode('mail_driver')
                        ->defaultValue('vibbe.notifications.processor')
                    ->end()
                ->end()
            ->end();


        return $treeBuilder;
    }

}
