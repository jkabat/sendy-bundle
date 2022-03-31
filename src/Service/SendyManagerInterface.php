<?php

declare(strict_types=1);

namespace Sendy\SendyBundle\Service;

use Sendy\SendyBundle\SendyException;

interface SendyManagerInterface
{
    /**
     * Get count of total active subscribers for the list
     *
     * @throws SendyException
     */
    public function getSubscriberCount(string $list = ''): int;

    /**
     * Get subscriber status for particular email
     *
     * @throws SendyException
     */
    public function getSubscriberStatus(string $email, string $list = ''): string;

    /**
     * Change list to a new one
     *
     * @throws SendyException
     */
    public function setList(string $list): void;

    /**
     * Subscribe particular email
     *
     * @throws SendyException
     */
    public function subscribe(string $name, string $email, string $list = ''): void;

    /**
     * Unsubscribe particular email
     *
     * @throws SendyException
     */
    public function unsubscribe(string $email, string $list = ''): void;
}
