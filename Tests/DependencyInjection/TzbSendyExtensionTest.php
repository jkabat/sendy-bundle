<?php

namespace Tzb\SendyBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Parser;

use Tzb\SendyBundle\DependencyInjection\TzbSendyExtension;

class TzbSendyExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testConfigLoadThrowsExceptionUnlessApiKeySet()
    {
        $container = new ContainerBuilder();
        $loader = new TzbSendyExtension();
        $config = $this->getEmptyConfig();
        unset($config['api_key']);
        $loader->load(array($config), $container);
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testConfigLoadThrowsExceptionUnlessApiHostSet()
    {
        $container = new ContainerBuilder();
        $loader = new TzbSendyExtension();
        $config = $this->getEmptyConfig();
        unset($config['api_host']);
        $loader->load(array($config), $container);
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testConfigLoadThrowsExceptionUnlessListIdSet()
    {
        $container = new ContainerBuilder();
        $loader = new TzbSendyExtension();
        $config = $this->getEmptyConfig();
        unset($config['list_id']);
        $loader->load(array($config), $container);
    }

    /**
     * {@inheritdoc}
     */
    public function testDefault()
    {
        $container = new ContainerBuilder();
        $loader = new TzbSendyExtension();
        $config = $this->getEmptyConfig();
        $loader->load(array($config), $container);

        // assert parameters
        $this->assertEquals($container->getParameter('tzb_sendy.api_key'), 'example_key');
        $this->assertEquals($container->getParameter('tzb_sendy.api_host'), 'http://example.host');
        $this->assertEquals($container->getParameter('tzb_sendy.list_id'), 'example_list');

        // assert service definition
        $this->assertTrue($container->hasDefinition('tzb_sendy.sendy_manager'), 'Manager service is loaded');
    }

    /**
     * getEmptyConfig
     *
     * @return array
     */
    protected function getEmptyConfig()
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
