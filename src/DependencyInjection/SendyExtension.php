<?php

namespace Sendy\SendyBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SendyExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        if ($config['api_host'] && strncmp($config['api_host'], 'http', 4) !== 0) {
            $config['api_host'] = 'http://'.$config['api_host'];
        }

        $container->setParameter('tzb_sendy.api_key', $config['api_key']);
        $container->setParameter('tzb_sendy.api_host', trim($config['api_host'], '/'));
        $container->setParameter('tzb_sendy.list_id', $config['list_id']);
    }
}
