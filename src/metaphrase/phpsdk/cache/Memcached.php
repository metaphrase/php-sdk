<?php

namespace metaphrase\phpsdk\cache;

use \metaphrase\phpsdk\ICache;

/**
 * File cache
 * 
 * Cache implementation using Memcached memory caching.
 * @author Spafaridis Xenophon <nohponex@gmail.com>
 * @link http://memcached.org/ Memcached website
 * @package metaphrase
 * @subpackage phpsdk
 * @todo Work in progress
 */
class Memcached implements ICache {

    /**
     * Time to live in seconds
     */
    private $TTL = 3600;
    private $debug = FALSE;

    /**
     * Initialize cache engine
     * @param array $connection Memcached connection settings.
     * @param integer $TTL [Optional] Life time of stored translated data.
     */
    public function __construct($connection, $TTL = 3600, $debug = FALSE) {

        $this->TTL = $TTL;
        $this->debug = $debug;
    }

    private function debug($data) {
        if ($this->debug) {
            print_r($data);
        }
    }

    /**
     * Store translated data in egnine
     * @param integer $id
     * @param string $language_code
     * @param array $data
     * @param array $type [Optional] Storage data type. Default is project
     */
    public function store($id, $language_code, $data, $type = ICache::TYPE_PROJECT) {
        $this->debug(['store', $id, $language_code, ['type' => $type]]);
    }

    /**
     * Get stored translated data from engine
     * @param integer $id
     * @param string $language_code
     * @param array $type [Optional] Storage data type. Default is project
     * @return array|NULL Translated data
     */
    public function fetch($id, $language_code, $type = ICache::TYPE_PROJECT) {
        $this->debug(['fetch', $id, $language_code, ['type' => $type]]);

        $this->debug(['miss']);
        return NULL;
    }

}
