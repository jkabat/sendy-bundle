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

        $config = $this->getEmptyConfig();
        unset($config['api_key']);
        $extension = new SendyExtension();
        $extension->load([$config], new ContainerBuilder());
    }

    public function testConfigLoadThrowsExceptionUnlessApiHostSet(): void
    {
        $this->expectException(InvalidConfigurationException::class);

        $config = $this->getEmptyConfig();
        unset($config['api_host']);
        $extension = new SendyExtension();
        $extension->load([$config], new ContainerBuilder());
    }

    public function testConfigLoadThrowsExceptionUnlessListIdSet(): void
    {
        $this->expectException(InvalidConfigurationException::class);

        $config = $this->getEmptyConfig();
        unset($config['list_id']);
        $extension = new SendyExtension();
        $extension->load([$config], new ContainerBuilder());
    }

    public function testDefault(): void
    {
        $container = new ContainerBuilder();
        $extension = new SendyExtension();
        $extension->load([$this->getEmptyConfig()], $container);

        $this->assertEquals('example_key', $container->getParameter('sendy.api_key'));
        $this->assertEquals('https://example.host', $container->getParameter('sendy.api_host'));
        $this->assertEquals('example_list', $container->getParameter('sendy.list_id'));

        $this->assertTrue($container->hasDefinition('sendy.sendy_manager'), 'Manager service is loaded');
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
