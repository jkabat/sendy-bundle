<?php

namespace Tzb\SendyBundle\Service;

use SendyPHP\SendyPHP;

/**
 * Manager for communication with Sendy.co api
 *
 * @author Juraj Kabát <kabat.juraj@gmail.com>
 */
class SendyManager implements SendyManagerInterface
{
    /** @var SendyPHP */
    protected $manager;

    /** @var string */
    protected $error = '';

    /**
     * @param string $apiKey
     * @param string $apiHost
     * @param string $list
     */
    public function __construct(
        $apiKey,
        $apiHost,
        $list
    ) {
        $config = array(
            'api_key' => $apiKey,
            'installation_url' => $apiHost,
            'list_id' => $list
        );

        $this->manager = new SendyPHP($config);
    }

    /**
     * Get error message and erase property
     *
     * @access public
     * @return string
     */
    public function getError()
    {
        $error = $this->error;
        $this->error = '';

        return $error;
    }

    /**
     * Get count of total active subscribers for the list
     *
     * @param string $list
     *
     * @access public
     * @return int
     */
    public function getSubscriberCount($list = '')
    {
        $result = $this->manager->subcount($list);

        // check status
        if (false === $result['status']) {
            $this->error = $result['message'];
            return false;
        }

        return (int) $result['message'];
    }

    /**
     * Get subscriber status for particular email
     *
     * @param string $email
     * @param string $list
     *
     * @access public
     * @return string
     */
    public function getSubscriberStatus($email, $list = '')
    {
        if ('' !== $list) {
            $this->setList($list);
        }

        $result = $this->manager->substatus($email);

        // check status
        if (false === $result['status']) {
            $this->error = $result['message'];
            return false;
        }

        return $result['message'];
    }

    /**
     * Change list to a new one
     *
     * @param string $list
     *
     * @access public
     * @return void
     */
    public function setList($list)
    {
        $this->manager->setListId($list);
    }

    /**
     * Subscribe particular email
     *
     * @param string $name
     * @param string $email
     * @param string $list
     *
     * @access public
     * @return bool
     */
    public function subscribe($name, $email, $list = '')
    {
        if ('' !== $list) {
            $this->setList($list);
        }

        $config = array(
            'name' => $name,
            'email' => $email,
        );

        $result = $this->manager->subscribe($config);

        // check status
        if (false === $result['status']) {
            $this->error = $result['message'];
            return false;
        }

        return true;
    }

    /**
     * Unsubscribe particular email
     *
     * @param string $email
     * @param string $list
     *
     * @access public
     * @return bool
     */
    public function unsubscribe($email, $list = '')
    {
        if ('' !== $list) {
            $this->setList($list);
        }

        $result = $this->manager->unsubscribe($email);

        // check status
        if (false === $result['status']) {
            $this->error = $result['message'];
            return false;
        }

        return true;
    }
}
