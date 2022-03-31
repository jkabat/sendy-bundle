<?php

declare(strict_types=1);

namespace Tests\Service;

use PHPUnit\Framework\TestCase;
use Sendy\SendyBundle\SendyException;
use Sendy\SendyBundle\Service\SendyManager;
use Sendy\SendyBundle\Service\SendyManagerInterface;
use Tests\Mocks\SendyPHP;

final class SendyManagerTest extends TestCase
{
    private ?SendyManager $manager = null;

    protected function setUp(): void
    {
        parent::setUp();

        // create mock for SendyPHP library
        $sendy = new SendyPHP([
            'api_key'           => 'example_key',
            'installation_url'  => 'example.host',
            'list_id'           => 'example_list',
        ]);

        // create SendyManager object
        $this->manager = new SendyManager($sendy);
    }

    protected function tearDown(): void
    {
        unset($this->manager);
    }

    /**
     * @test
     */
    public function testImplementedInterface()
    {
        $this->assertTrue($this->manager instanceof SendyManagerInterface);
    }

    /**
     * @test
     */
    public function testGetSubscriberCount()
    {
        $this->assertEquals((int) 2, $this->manager->getSubscriberCount());
    }

    public function testGetSubscriberCountWithWrongList()
    {
        $this->expectException(SendyException::class);
        $this->manager->getSubscriberCount('wrong_list');
    }

    /**
     * @test
     */
    public function testGetSubscriberStatus()
    {
        $this->assertEquals('Subscribed', $this->manager->getSubscriberStatus('john@example.com'));
    }

    public function testGetSubscriberStatusWithWrongEmail()
    {
        $this->expectException(SendyException::class);
        $this->manager->getSubscriberStatus('fred@example.com');
    }

    public function testGetSubscriberStatusWithWrongList()
    {
        $this->expectException(SendyException::class);
        $this->manager->getSubscriberStatus('john@example.com', 'wrong_list');
    }

    /**
     * @test
     */
    public function testSubscribeWithNewEmail()
    {
        $this->assertTrue($this->manager->subscribe('Fred Combs', 'fred@example.com'));
    }

    /**
     * @test
     */
    public function testSubscribeWithExistentEmail()
    {
        $this->assertTrue($this->manager->subscribe('John Doe', 'john@example.com'));
    }

    public function testSubscribeWithWrongList()
    {
        $this->expectException(SendyException::class);
        $this->manager->subscribe('Fred Combs', 'fred@example.com', 'wrong_list');
    }

    /**
     * @test
     */
    public function testUnsubscribe()
    {
        $this->assertTrue($this->manager->unsubscribe('john@example.com'));
    }

    public function testUnsubscribeWithWrongEmail()
    {
        $this->expectException(SendyException::class);
        $this->manager->unsubscribe('fred@example.com');
    }

    public function testUnsubscribeWithWrongList()
    {
        $this->expectException(SendyException::class);
        $this->manager->unsubscribe('fred@example.com', 'wrong_list');
    }
}
