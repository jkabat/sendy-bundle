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
    /** @var SendyManager */
    private $manager = null;

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
        self::assertInstanceOf(SendyManagerInterface::class, $this->manager);
    }

    public function testGetSubscriberCount(): void
    {
        self::assertEquals(2, $this->manager->getSubscriberCount());
    }

    public function testGetSubscriberCountWithWrongList(): void
    {
        self::expectException(SendyException::class);
        $this->manager->getSubscriberCount('wrong_list');
    }

    public function testGetSubscriberStatus(): void
    {
        self::assertEquals('Subscribed', $this->manager->getSubscriberStatus('john@example.com'));
    }

    public function testGetSubscriberStatusWithWrongEmail(): void
    {
        self::expectException(SendyException::class);
        $this->manager->getSubscriberStatus('fred@example.com');
    }

    public function testGetSubscriberStatusWithWrongList(): void
    {
        self::expectException(SendyException::class);
        $this->manager->getSubscriberStatus('john@example.com', 'wrong_list');
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testSubscribeWithNewEmail(): void
    {
        $this->manager->subscribe('Fred Combs', 'fred@example.com');
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testSubscribeWithExistentEmail(): void
    {
        $this->manager->subscribe('John Doe', 'john@example.com');
    }

    public function testSubscribeWithWrongList(): void
    {
        self::expectException(SendyException::class);
        $this->manager->subscribe('Fred Combs', 'fred@example.com', 'wrong_list');
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testUnsubscribe(): void
    {
        $this->manager->unsubscribe('john@example.com');
    }

    public function testUnsubscribeWithWrongEmail(): void
    {
        self::expectException(SendyException::class);
        $this->manager->unsubscribe('fred@example.com');
    }

    public function testUnsubscribeWithWrongList(): void
    {
        self::expectException(SendyException::class);
        $this->manager->unsubscribe('fred@example.com', 'wrong_list');
    }
}
