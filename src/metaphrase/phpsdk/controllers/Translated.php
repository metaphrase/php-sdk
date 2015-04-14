<?php

namespace metaphrase\phpsdk\controllers;

use \metaphrase\phpsdk\Metaphrase;
use metaphrase\phpsdk\MetaphraseException;

/**
 * Translated controller
 * 
 * Expands SDK's methods allowing to access translated data
 * @author Spafaridis Xenophon <nohponex@gmail.com>
 * @package metaphrase
 * @subpackage phpsdk
 * @todo Work in progress
 */
class Translated {

    private $metaphrase;

    /**
     * Initialize class
     * @param object $metaphrase
     */
    public function __construct(Metaphrase $metaphrase) {
        $this->metaphrase = $metaphrase;
    }

    /**
     * Get all translation keys
     * @throws MetaphraseException on failure
     * @param integer $project_id Project's id
     * @param string $language_code Lanuage Code
     * @param boolean $use_cached [Optional] If true, the SDK will attempt to use the selected cache machine. Default TRUE
     * @return array Returns translation array for selected language
     */
    public function fetch($project_id, $language_code, $use_cached = TRUE) {
        $caching_engine = $this->metaphrase->get_cache_engine();

        $use_cached &= $caching_engine !== NULL;

        //Use cached
        if ($use_cached) {
            $cached = $caching_engine->fetch($project_id, $language_code);

            if ($cached !== NULL) {
                return $cached;
            }
        }

        $p = array('id' => $project_id, 'language' => $language_code);

        $r = $this->metaphrase->request(( 'fetch/listing?' . http_build_query($p)), Metaphrase::METHOD_GET);

        if ($use_cached && $r && isset($r['translation'])) {
            $caching_engine->store($project_id, $language_code, $r['translation']);
        }

        return $r['translation'];
    }

}
