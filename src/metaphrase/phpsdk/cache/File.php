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
class File implements metaphrase\phpsdk\ICache {
    
    const SETTING_PATH       = 1;
    const SETTING_FORMAT     = 2;
    
    private $settings;
    
    /**
     * Initialize cache
     * @param type $settings
     */
    public function __construct($settings) {
        $this->settings = $settings;
    }
    public function store($id, $language_code, $data){
        
    }
    public function fetch($id, $language_code){
        
    }
}
