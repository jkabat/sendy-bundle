<?php

namespace Tzb\SendyBundle\Service;

use SendyPHP\SendyPHP;
use Tzb\SendyBundle\SendyException;

/**
 * Manager for communication with Sendy.co api
 *
 * @author Juraj Kabát <kabat.juraj@gmail.com>
 */
class SendyManager implements SendyManagerInterface
{
    /** @var SendyPHP */
    protected $sendy;

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

        $this->sendy = new SendyPHP($config);
    }

    /**
     * Get count of total active subscribers for the list
     *
     * @param string $list
     *
     * @access public
     * @return int
     * @throws SendyException
     */
    public function getSubscriberCount($list = '')
    {
        $result = $this->sendy->subcount($list);

        // check status and throw exception
        if (false === $result['status']) {
            throw new SendyException($result['message']);
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
     * @throws SendyException
     */
    public function getSubscriberStatus($email, $list = '')
    {
        if ('' !== $list) {
            $this->setList($list);
        }

        $result = $this->sendy->substatus($email);

        // check status and throw exception
        if (false === $result['status']) {
            throw new SendyException($result['message']);
        }

        return $result['message'];
    }

    /**
     * Change list to a new one
     *
     * @param string $list
     *
     * @access public
     */
    public function setList($list)
    {
        $this->sendy->setListId($list);
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
     * @throws SendyException
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

        $result = $this->sendy->subscribe($config);

        // check status and throw exception
        if (false === $result['status']) {
            throw new SendyException($result['message']);
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
     * @throws SendyException
     */
    public function unsubscribe($email, $list = '')
    {
        if ('' !== $list) {
            $this->setList($list);
        }

        $result = $this->sendy->unsubscribe($email);

        // check status and throw exception
        if (false === $result['status']) {
            throw new SendyException($result['message']);
        }

        return true;
    }
}
