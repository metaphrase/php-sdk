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
     * Cached datatype project, used to store all project's translations for a language
     */
    const TYPE_PROJECT = 'project';
    
    /**
     * Cached datatype keyword, used to store keyword's translations for a language
     */
    const TYPE_KEYWORD = 'keyword';
    /**
     * Store translated data in egnine
     * @param integer $id
     * @param string $language_code
     * @param array $data
     * @param array $type [Optional] Storage data type. Default is project
     */
    public function store($id, $language_code, $data, $type= ICache::TYPE_PROJECT);

    /**
     * Get stored translated data from engine
     * @param integer $id
     * @param string $language_code
     * @param array $type [Optional] Storage data type. Default is project
     * @return array|NULL Translated data
     */
    public function fetch($id, $language_code, $type= ICache::TYPE_PROJECT);
}
