<?php

namespace Tzb\SendyBundle\Tests\Mocks;

use Tzb\SendyBundle\Service\SendyManager as Base;

/**
 * Mock of manager for communication with Sendy.co api
 *
 * @author Juraj Kabát <kabat.juraj@gmail.com>
 */
class SendyManager extends Base
{
    /**
     * Override sendy library instantiated in constructor
     *
     * @param SendyPHP $sendy
     *
     * @access public
     */
    public function setSendy(SendyPHP $sendy)
    {
        $this->sendy = $sendy;
    }
}
