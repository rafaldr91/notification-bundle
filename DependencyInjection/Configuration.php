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
                ->end()
            ->end();


        return $treeBuilder;
    }

}
