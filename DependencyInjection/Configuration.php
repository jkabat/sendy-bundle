<?php

namespace Tzb\SendyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('tzb_sendy');

        // define the parameters that are allowed to configure your SendyBundle
        $this->addSendySection($rootNode);

        return $treeBuilder;
    }

    /**
     * Parses the tzb_sendy block config section
     * Example for yaml section:
     * tzb_sendy:
     *     api_key: "yourapiKEYHERE"
     *     api_host: "http://updates.mydomain.com"
     *     list_id: "your_list_id_goes_here"
     *
     * @param ArrayNodeDefinition $node
     * @return void
     */
    private function addSendySection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('api_key')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('api_host')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('list_id')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
            ->end()
        ;
    }
}
