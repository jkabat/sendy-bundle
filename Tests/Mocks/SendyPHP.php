<?php

namespace Tzb\SendyBundle\Tests\Mocks;

use SendyPHP\SendyPHP as Base;

/**
 * Mock of SendyPHP library
 *
 * @author Juraj Kabát <kabat.juraj@gmail.com>
 */
class SendyPHP extends Base
{
    private $lists = array(
        'example_list',
        'example_list2',
    );

    private $subscribers = array(
        'example_list' => array(
            'john@example.com',
            'jane@example.com',
        ),
        'example_list2' => array(),
    );

    /**
     * {@inheritdoc}
     */
    public function subcount($list = '')
    {
        $list = $list === '' ? $this->list_id : $list;

        if (!in_array($list, $this->lists)) {
            return $this->response(false, 'Error.');
        }

        return $this->response(true, count($this->subscribers[$list]));
    }

    /**
     * {@inheritdoc}
     */
    public function substatus($email)
    {
        if (!in_array($this->list_id, $this->lists) ||
            !in_array($email, $this->subscribers[$this->list_id])) {
            return $this->response(false, 'Error.');
        }

        return $this->response(true, 'Subscribed');
    }

    /**
     * {@inheritdoc}
     */
    public function subscribe(array $values)
    {
        if (!in_array($this->list_id, $this->lists)) {
            return $this->response(false, 'Error.');
        }

        if (in_array($values['email'], $this->subscribers[$this->list_id])) {
            return $this->response(true, 'Already subscribed');
        }

        return $this->response(true, 'Subscribed');
    }

    /**
     * {@inheritdoc}
     */
    public function unsubscribe($email)
    {
        if (!in_array($this->list_id, $this->lists) ||
            !in_array($email, $this->subscribers[$this->list_id])) {
            return $this->response(false, 'Error.');
        }

        return $this->response(true, 'Unsubscribed');
    }

    /**
     * Response
     *
     * @param bool $status
     * @param string $message
     *
     * @access private
     * @return array
     */
    private function response($status, $message = "")
    {
        return array(
            'status' => $status,
            'message' => $message,
        );
    }
}
