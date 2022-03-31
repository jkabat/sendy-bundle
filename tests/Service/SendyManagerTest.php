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
            'api_key' => 'example_key',
            'installation_url' => 'example.host',
            'list_id' => 'example_list',
        ]);

        // create SendyManager object
        $this->manager = new SendyManager($sendy);
    }

    protected function tearDown(): void
    {
        unset($this->manager);
    }

    public function testImplementedInterface(): void
    {
        $this->assertTrue($this->manager instanceof SendyManagerInterface);
    }

    public function testGetSubscriberCount(): void
    {
        $this->assertEquals(2, $this->manager->getSubscriberCount());
    }

    public function testGetSubscriberCountWithWrongList(): void
    {
        $this->expectException(SendyException::class);
        $this->manager->getSubscriberCount('wrong_list');
    }

    public function testGetSubscriberStatus(): void
    {
        $this->assertEquals('Subscribed', $this->manager->getSubscriberStatus('john@example.com'));
    }

    public function testGetSubscriberStatusWithWrongEmail(): void
    {
        $this->expectException(SendyException::class);
        $this->manager->getSubscriberStatus('fred@example.com');
    }

    public function testGetSubscriberStatusWithWrongList(): void
    {
        $this->expectException(SendyException::class);
        $this->manager->getSubscriberStatus('john@example.com', 'wrong_list');
    }

    public function testSubscribeWithNewEmail(): void
    {
        $this->assertNull($this->manager->subscribe('Fred Combs', 'fred@example.com'));
    }

    public function testSubscribeWithExistentEmail(): void
    {
        $this->assertNull($this->manager->subscribe('John Doe', 'john@example.com'));
    }

    public function testSubscribeWithWrongList(): void
    {
        $this->expectException(SendyException::class);
        $this->manager->subscribe('Fred Combs', 'fred@example.com', 'wrong_list');
    }

    public function testUnsubscribe(): void
    {
        $this->assertNull($this->manager->unsubscribe('john@example.com'));
    }

    public function testUnsubscribeWithWrongEmail(): void
    {
        $this->expectException(SendyException::class);
        $this->manager->unsubscribe('fred@example.com');
    }

    public function testUnsubscribeWithWrongList(): void
    {
        $this->expectException(SendyException::class);
        $this->manager->unsubscribe('fred@example.com', 'wrong_list');
    }
}
