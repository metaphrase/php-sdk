<?php

namespace metaphrase\phpsdk\cache;

use \metaphrase\phpsdk\ICache;
/**
 * Simle cache
 * 
 * For demonstration purpose only, not useful in production.
 * Cache implementation using variables
 * @license http://www.gnu.org/licenses/lgpl-2.1.html LGPL License 2.1
 * @copyright (c) 2014-2015, Spafaridis Xenophon
 * @author Spafaridis Xenophon <nohponex@gmail.com>
 * @package metaphrase
 * @subpackage phpsdk
 */
class Simple implements ICache {

    /**
     * Internal storage variable
     * @var array
     */
    private static $storage = [];

    /**
     * Initialize cache engine
     */
    public function __construct() {
        print_r(['Simple chache engine']);
    }

    /**
     * Store translated data in egnine
     * @param integer $id
     * @param string $language_code
     * @param array $data
     * @param array $type [Optional] Storage data type. Default is project
     */
    public function store($id, $language_code, $data, $type = ICache::TYPE_PROJECT) {
        print_r(['store', $id, $language_code]);

        $key = md5(implode('-', [$type, $id, $language_code]));

        self::$storage[$key] = $data;
        return FALSE;
    }

    /**
     * Get stored translated data from engine
     * @param integer $id
     * @param string $language_code
     * @param array $type [Optional] Storage data type. Default is project
     * @return array|NULL Translated data
     */
    public function fetch($id, $language_code, $type = ICache::TYPE_PROJECT) {
        print_r(['fetch', $id, $language_code]);

        $key = md5(implode('-', [$type, $id, $language_code]));

        if (isset(self::$storage[$key])) {
            print_r(['hit']);
            return self::$storage[$key];
        }
        print_r(['miss']);
        return NULL;
    }

}
