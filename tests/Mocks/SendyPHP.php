<?php

declare(strict_types=1);

namespace Tests\Mocks;

use SendyPHP\SendyPHP as Base;

final class SendyPHP extends Base
{
    private array $lists = [
        'example_list',
        'example_list2',
    ];

    private array $subscribers = [
        'example_list' => [
            'john@example.com',
            'jane@example.com',
        ],
        'example_list2' => [],
    ];

    public function subcount($list = ''): array
    {
        $list = '' === $list ? $this->list_id : $list;

        if (!in_array($list, $this->lists)) {
            return $this->response(false, 'Error.');
        }

        return $this->response(true, (string) count($this->subscribers[$list]));
    }

    public function substatus($email): array
    {
        if (!in_array($this->list_id, $this->lists) ||
            !in_array($email, $this->subscribers[$this->list_id])) {
            return $this->response(false, 'Error.');
        }

        return $this->response(true, 'Subscribed');
    }

    public function subscribe(array $values): array
    {
        if (!in_array($this->list_id, $this->lists)) {
            return $this->response(false, 'Error.');
        }

        if (in_array($values['email'], $this->subscribers[$this->list_id])) {
            return $this->response(true, 'Already subscribed');
        }

        return $this->response(true, 'Subscribed');
    }

    public function unsubscribe($email): array
    {
        if (!in_array($this->list_id, $this->lists) ||
            !in_array($email, $this->subscribers[$this->list_id])) {
            return $this->response(false, 'Error.');
        }

        return $this->response(true, 'Unsubscribed');
    }

    private function response(bool $status, string $message = ''): array
    {
        return [
            'status' => $status,
            'message' => $message,
        ];
    }
}
