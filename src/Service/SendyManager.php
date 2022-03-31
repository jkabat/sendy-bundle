<?php

declare(strict_types=1);

namespace Sendy\SendyBundle\Service;

use SendyPHP\SendyPHP;
use Sendy\SendyBundle\SendyException;

final class SendyManager implements SendyManagerInterface
{
    private SendyPHP $sendy;

    public function __construct(SendyPHP $sendy)
    {
        $this->sendy = $sendy;
    }

    /**
     * @throws SendyException
     */
    public function getSubscriberCount(string $list = ''): int
    {
        if ('' !== $list) {
            $this->setList($list);
        }

        try {
            $result = $this->sendy->subcount($list);

            if (false === $result['status']) { // check status and throw exception
                throw new SendyException($result['message']);
            }

            return (int) $result['message'];
        } catch (\Exception $exception) {
            throw new SendyException($exception->getMessage());
        }
    }

    /**
     * @throws SendyException
     */
    public function getSubscriberStatus(string $email, string $list = ''): string
    {
        if ('' !== $list) {
            $this->setList($list);
        }

        try {
            $result = $this->sendy->substatus($email);

            if (false === $result['status']) { // check status and throw exception
                throw new SendyException($result['message']);
            }

            return $result['message'];
        } catch (\Exception $exception) {
            throw new SendyException($exception->getMessage());
        }
    }

    /**
     * @throws SendyException
     */
    public function setList(string $list): void
    {
        try {
            $this->sendy->setListId($list);
        } catch (\Exception $exception) {
            throw new SendyException($exception->getMessage());
        }
    }

    /**
     * @throws SendyException
     */
    public function subscribe(string $name, string $email, string $list = ''): void
    {
        if ('' !== $list) {
            $this->setList($list);
        }

        try {
            $result = $this->sendy->subscribe([
                'name' => $name,
                'email' => $email,
            ]);

            if (false === $result['status']) { // check status and throw exception
                throw new SendyException($result['message']);
            }
        } catch (\Exception $exception) {
            throw new SendyException($exception->getMessage());
        }
    }

    /**
     * @throws SendyException
     */
    public function unsubscribe(string $email, string $list = ''): void
    {
        if ('' !== $list) {
            $this->setList($list);
        }

        try {
            $result = $this->sendy->unsubscribe($email);

            if (false === $result['status']) { // check status and throw exception
                throw new SendyException($result['message']);
            }
        } catch (\Exception $exception) {
            throw new SendyException($exception->getMessage());
        }
    }
}
