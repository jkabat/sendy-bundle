<?php

declare(strict_types=1);

namespace Tests\Mocks;

use SendyPHP\SendyPHP as Base;

final class SendyPHP extends Base
{
    /** @var array<string> */
    private array $lists = [
        'example_list',
        'example_list2',
    ];

    /**
     * @var array<string, array<int, string>>
     */
    private array $subscribers = [
        'example_list' => [
            'john@example.com',
            'jane@example.com',
        ],
        'example_list2' => [],
    ];

    /**
     * @param string|mixed $list
     * @return array<string, bool|string>
     */
    public function subcount($list = ''): array
    {
        $list = '' === $list ? $this->list_id : $list;

        if (!in_array($list, $this->lists, true)) {
            return $this->response(false, 'Error.');
        }

        return $this->response(true, (string) count($this->subscribers[$list]));
    }

    /**
     * @param string|mixed $email
     * @return array<string, bool|string>
     */
    public function substatus($email): array
    {
        if (!in_array($this->list_id, $this->lists, true) ||
            !in_array($email, $this->subscribers[$this->list_id], true)) {
            return $this->response(false, 'Error.');
        }

        return $this->response(true, 'Subscribed');
    }

    /**
     * @param array<string, string>|array<mixed> $values
     * @return array<string, bool|string>
     */
    public function subscribe(array $values): array
    {
        if (!in_array($this->list_id, $this->lists, true)) {
            return $this->response(false, 'Error.');
        }

        if (in_array($values['email'], $this->subscribers[$this->list_id], true)) {
            return $this->response(true, 'Already subscribed');
        }

        return $this->response(true, 'Subscribed');
    }

    /**
     * @param string|mixed $email
     * @return array<string, bool|string>
     */
    public function unsubscribe($email): array
    {
        if (!in_array($this->list_id, $this->lists, true) ||
            !in_array($email, $this->subscribers[$this->list_id], true)) {
            return $this->response(false, 'Error.');
        }

        return $this->response(true, 'Unsubscribed');
    }

    /**
     * @param bool $status
     * @param string $message
     * @return array<string, bool|string>
     */
    private function response(bool $status, string $message = ''): array
    {
        return [
            'status' => $status,
            'message' => $message,
        ];
    }
}
