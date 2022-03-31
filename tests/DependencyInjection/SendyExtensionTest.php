<?php

declare(strict_types=1);

namespace Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Parser;
use Sendy\SendyBundle\DependencyInjection\SendyExtension;

final class SendyExtensionTest extends TestCase
{
    public function testConfigLoadThrowsExceptionUnlessApiKeySet(): void
    {
        $this->expectException(InvalidConfigurationException::class);

        $container = new ContainerBuilder();
        $loader = new SendyExtension();
        $config = $this->getEmptyConfig();
        unset($config['api_key']);
        $loader->load(array($config), $container);
    }

    public function testConfigLoadThrowsExceptionUnlessApiHostSet(): void
    {
        $this->expectException(InvalidConfigurationException::class);

        $container = new ContainerBuilder();
        $loader = new SendyExtension();
        $config = $this->getEmptyConfig();
        unset($config['api_host']);
        $loader->load(array($config), $container);
    }

    public function testConfigLoadThrowsExceptionUnlessListIdSet(): void
    {
        $this->expectException(InvalidConfigurationException::class);

        $container = new ContainerBuilder();
        $loader = new SendyExtension();
        $config = $this->getEmptyConfig();
        unset($config['list_id']);
        $loader->load(array($config), $container);
    }

    public function testDefault(): void
    {
        $container = new ContainerBuilder();
        $loader = new SendyExtension();
        $config = $this->getEmptyConfig();
        $loader->load(array($config), $container);

        // assert parameters
        $this->assertEquals($container->getParameter('tzb_sendy.api_key'), 'example_key');
        $this->assertEquals($container->getParameter('tzb_sendy.api_host'), 'http://example.host');
        $this->assertEquals($container->getParameter('tzb_sendy.list_id'), 'example_list');

        // assert service definition
        $this->assertTrue($container->hasDefinition('tzb_sendy.sendy_manager'), 'Manager service is loaded');
    }

    private function getEmptyConfig(): array
    {
        $yaml = <<<EOF
api_key: example_key
api_host: example.host
list_id: example_list
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }
}
