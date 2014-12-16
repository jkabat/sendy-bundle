<?php

namespace Tzb\SendyBundle\Service;

use Tzb\SendyBundle\SendyException;

/**
 * Manager interface for communication with Sendy.co api
 *
 * @author Juraj Kabát <kabat.juraj@gmail.com>
 */
interface SendyManagerInterface
{
    /**
     * Get count of total active subscribers for the list
     *
     * @param string $list
     *
     * @access public
     * @return int
     * @throws SendyException
     */
    public function getSubscriberCount($list = '');

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
    public function getSubscriberStatus($email, $list = '');

    /**
     * Change list to a new one
     *
     * @param string $list
     *
     * @access public
     * @return void
     */
    public function setList($list);

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
    public function subscribe($name, $email, $list = '');

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
    public function unsubscribe($email, $list = '');
}
