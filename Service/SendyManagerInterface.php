<?php

namespace Tzb\SendyBundle\Service;

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
     * @return int|bool
     */
    public function getSubscriberCount($list = '');

    /**
     * Get subscriber status for particular email
     *
     * @param string $email
     * @param string $list
     *
     * @access public
     * @return string|bool
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
     */
    public function unsubscribe($email, $list = '');
}
