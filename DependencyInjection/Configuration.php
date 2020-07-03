<?php


namespace Vibbe\NewsletterHelper\DependencyInjection;


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
                        ->defaultValue('none')
                    ->end()
                    ->scalarNode('swift_mailer_service')
                        ->defaultValue('')
                    ->end()
                    ->scalarNode('mail_driver_custom')
                        ->defaultValue('')
                    ->end()
                ->end()
            ->end();


        return $treeBuilder;
    }

}