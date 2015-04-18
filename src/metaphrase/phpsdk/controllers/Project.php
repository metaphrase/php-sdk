<?php

namespace metaphrase\phpsdk\controllers;

use \metaphrase\phpsdk\Metaphrase;
use metaphrase\phpsdk\MetaphraseException;

/**
 * projects controller
 * 
 * Expands SDK's methods allowing to manage projects
 * @author Spafaridis Xenophon <nohponex@gmail.com>
 * @package metaphrase
 * @subpackage phpsdk
 * @todo Work in progress
 */
class Project {

    private $metaphrase;

    /**
     * Initialize class
     * @param Metaphrase $metaphrase
     */
    public function __construct(Metaphrase $metaphrase) {
        $this->metaphrase = $metaphrase;
    }

    /**
     * Add new project
     */
    public function post() {
        throw new \Exception('not implemented');
    }

}
