<?php

declare(strict_types=1);

namespace Sendy\SendyBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

final class SendyExtension extends Extension
{
    /**
     * @param array<mixed> $configs
     * @param ContainerBuilder $container
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        if ($config['api_host'] && 0 !== strncmp($config['api_host'], 'https', 5)) {
            $config['api_host'] = 'https://'.$config['api_host'];
        }

        $container->setParameter('sendy.api_key', $config['api_key']);
        $container->setParameter('sendy.api_host', trim($config['api_host'], '/'));
        $container->setParameter('sendy.list_id', $config['list_id']);
    }
}
