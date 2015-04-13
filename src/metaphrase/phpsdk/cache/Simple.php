<?php
namespace metaphrase\phpsdk\cache;

/**
 * Simle cache
 * 
 * Cache implementation using variables
 * @author Spafaridis Xenophon <nohponex@gmail.com>
 * @package metaphrase
 * @subpackage phpsdk
 * @todo Work in progress
 */
class Simple implements \metaphrase\phpsdk\ICache {
    
    const SETTING_PATH       = 1;
    const SETTING_FORMAT     = 2;
    
    /**
     * Time to live in seconds
     */
    const SETTING_TTL        = 3600;
    private $settings;
    
    private static $storage = [];
    
    /**
     * Initialize cache engine
     */
    public function __construct() {
        print_r(['Simple chache engine']);
    }
    public function store($id, $language_code, $data){
        print_r(['store', $id, $language_code]);
        
        $key = md5(implode('-', [$id, $language_code]));
        
        self::$storage[$key] = $data;
        return FALSE;
    }
    public function fetch($id, $language_code){
        print_r(['fetch', $id, $language_code]);
        
        $key = md5(implode('-', [$id, $language_code]));
        
        if(isset(self::$storage[$key])){
            print_r(['hit']);
            return self::$storage[$key];
        }
        print_r(['miss']);
        return NULL;
    }
}
