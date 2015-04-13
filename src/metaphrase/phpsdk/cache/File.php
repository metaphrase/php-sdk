<?php
namespace metaphrase\phpsdk\cache;

/**
 * File cache
 * 
 * Cache implementation using files
 * @author Spafaridis Xenophon <nohponex@gmail.com>
 * @package metaphrase
 * @subpackage phpsdk
 * @todo Work in progress
 */
class File implements \metaphrase\phpsdk\ICache {
    
    const SETTING_PATH       = 1;
    const SETTING_FORMAT     = 2;
    
    /**
     * Time to live in seconds
     */
    const SETTING_TTL        = 3600;
    private $settings;
    
    /**
     * Initialize cache engine
     */
    public function __construct($settings) {
        throw new \Exception('not implemented');
    }
    public function store($id, $language_code, $data){
        print_r(['store', $id, $language_code, $data]);
        
        return FALSE;
    }
    public function fetch($id, $language_code){
        print_r(['fetch', $id, $language_code]);
        
        return NULL;
    }
}
