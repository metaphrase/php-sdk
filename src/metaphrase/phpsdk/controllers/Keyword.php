<?php

namespace metaphrase\phpsdk\controllers;

use \metaphrase\phpsdk\Metaphrase;
use metaphrase\phpsdk\MetaphraseException;
/**
 * keyword controller
 * 
 * Expands SDK's methods allowing to manage keywords
 * @author Spafaridis Xenophon <nohponex@gmail.com>
 * @package metaphrase
 * @subpackage phpsdk
 * @todo Work in progress
 */
class Keyword {

    private $metaphrase;

    /**
     * Initialize class
     * @param Metaphrase $metaphrase
     */
    public function __construct(Metaphrase $metaphrase) {
        $this->metaphrase = $metaphrase;
    }

    /**
     * Add new keyword
     * @todo Convert to metaphrase API
     */
    public function post($keyword_group_id, $key) {
        $p = array('id' => $keyword_group_id, 'key' => $keyword);

        try {
            $r = $this->metaphrase->request('fetch/create?', Metaphrase::METHOD_POST, $p);
        } catch (MetaphraseException $e) {
            //Key exists
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Get a keyword
     */
    public function get($id) {
        throw new \Exception('not implemented');
    }

    /**
     * Delete a keyword
     */
    public function delete($id) {
        throw new \Exception('not implemented');
    }

}
