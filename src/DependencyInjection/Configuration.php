<?php

declare(strict_types=1);

namespace Sendy\SendyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('sendy');
        $rootNode = $treeBuilder->getRootNode();

        $this->addSendySection($rootNode);

        return $treeBuilder;
    }

    /**
     * Parses the "sendy" block config section
     * Example for yaml section:
     * sendy:
     *     api_key: "yourapiKEYHERE"
     *     api_host: "https://updates.mydomain.com"
     *     list_id: "your_list_id_goes_here"
     */
    private function addSendySection(ArrayNodeDefinition $node): void
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
            ->end();
    }
}
