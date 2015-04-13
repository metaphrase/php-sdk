<?php

namespace metaphrase\phpsdk;

/**
 * ICache cache engine interface
 * 
 * @author Spafaridis Xenophon <nohponex@gmail.com>
 * @package metaphrase
 * @subpackage phpsdk
 * @todo Work in progress
 */
interface ICache {

    /**
     * Store translated data in egnine
     * @param integer $id
     * @param string $language_code
     * @param array $data
     * @param array $type Storage type [Optional] Default is project
     */
    public function store($id, $language_code, $data, $type= 'project');

    /**
     * Get stored translated data from engine
     * @param integer $id
     * @param string $language_code
     * @param array $type Storage type [Optional] Default is project
     * @return array|NULL Translated data
     */
    public function fetch($id, $language_code, $type= 'project');
}
