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
        self::expectException(InvalidConfigurationException::class);

        $config = $this->getEmptyConfig();
        unset($config['api_key']);
        $extension = new SendyExtension();
        $extension->load([$config], new ContainerBuilder());
    }

    public function testConfigLoadThrowsExceptionUnlessApiHostSet(): void
    {
        self::expectException(InvalidConfigurationException::class);

        $config = $this->getEmptyConfig();
        unset($config['api_host']);
        $extension = new SendyExtension();
        $extension->load([$config], new ContainerBuilder());
    }

    public function testConfigLoadThrowsExceptionUnlessListIdSet(): void
    {
        self::expectException(InvalidConfigurationException::class);

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

        self::assertEquals('example_key', $container->getParameter('sendy.api_key'));
        self::assertEquals('https://example.host', $container->getParameter('sendy.api_host'));
        self::assertEquals('example_list', $container->getParameter('sendy.list_id'));

        self::assertTrue($container->hasDefinition('sendy.sendy_manager'), 'Manager service is loaded');
    }

    /**
     * @return array<string, string>
     */
    private function getEmptyConfig(): array
    {
        $yaml = <<<EOF
api_key: example_key
api_host: example.host
list_id: example_list
EOF;
        $parser = new Parser();
        // @phpstan-ignore-next-line
        return $parser->parse($yaml);
    }
}
