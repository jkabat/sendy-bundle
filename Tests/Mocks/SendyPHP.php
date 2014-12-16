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
    protected $installation_url;
    protected $api_key;
    protected $list_id;

    protected $subscribers = array(
        'john@example.com' => array(
            'name'          => 'John Doe',
            'subscribed'    => true,
        ),
        'jane@example.com' => array(
            'name'          => 'Jane Doe',
            'subscribed'    => false,
        )
    );

    /**
     * {@inheritdoc}
     */
    public function __construct(array $config)
    {
        $this->api_key = $config['api_key'];
        $this->installation_url = $config['installation_url'];
        $this->list_id = $config['list_id'];
    }

    /**
     * {@inheritdoc}
     */
    public function subcount($list = "")
    {
        if ('' === $list ||
            $this->list_id === $list) {
            return array(
                'status' => true,
                'message' => count($this->subscribers),
            );
        }

        return array(
            'status' => false,
            'message' => 'Error.'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function substatus($email)
    {
        if ('example_list' === $this->list_id &&
            isset($this->subscribers[$email])) {
            return array(
                'status' => true,
                'message' => 'Subscribed'
            );
        }

        return array(
            'status' => false,
            'message' => 'Error'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function subscribe(array $values)
    {
        if ('example_list' === $this->list_id) {
            if (isset($this->subscribers[$values['email']])) {
                return array(
                    'status' => true,
                    'message' => 'Already subscribed'
                );
            }

            return array(
                'status' => true,
                'message' => 'Subscribed'
            );
        }

        return array(
            'status' => false,
            'message' => 'Error'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function unsubscribe($email)
    {
        if ('example_list' === $this->list_id) {
            if (isset($this->subscribers[$email])) {
                return array(
                    'status' => true,
                    'message' => 'Unsubscribed'
                );
            }
        }

        return array(
            'status' => false,
            'message' => 'Error'
        );
    }
}