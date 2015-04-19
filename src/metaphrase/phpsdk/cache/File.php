<?php

namespace metaphrase\phpsdk\cache;

use \metaphrase\phpsdk\ICache;
/**
 * File cache
 * 
 * Cache implementation using files.
 * @license http://www.gnu.org/licenses/lgpl-2.1.html LGPL License 2.1
 * @copyright (c) 2014-2015, Spafaridis Xenophon
 * @author Spafaridis Xenophon <nohponex@gmail.com>
 * @package metaphrase
 * @subpackage phpsdk
 * @todo clean old files
 * @todo additional formats
 */
class File implements ICache {

    private $path;
    private $format;

    /**
     * Time to live in seconds
     */
    private $TTL = 3600;
    private $debug = FALSE;

    /**
     * Initialize cache engine
     * @param string $path Temporary filesystem directory to store the translated data. MUST be writeable.
     * @param string $format [Optional] Stored file format. Default is serialized php array
     * @param integer $TTL [Optional] Life time of stored translated data.
     */
    public function __construct($path, $format = 'phparray', $TTL = 3600, $debug = FALSE) {
        $this->path = $path;
        $this->format = $format;
        $this->TTL = $TTL;
        $this->debug = $debug;

        if (!is_writable($path)) {
            throw new \Exception($path . ' is not writeable!');
        }
    }

    private function debug($data) {
        if ($this->debug) {
            print_r($data);
        }
    }

    /**
     * Create file path
     * 
     * @param integer $id
     * @param string $language_code
     * @return string File's path
     */
    private function file($id, $language_code, $type) {

        $key = ($type . '-' . $id . '-' . $language_code); //sha1
        $extension = '.phparray';

        //prevent double slashes
        $file_path = str_replace(
            DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, $this->path . DIRECTORY_SEPARATOR . $key . $extension
        );

        return $file_path;
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

        $file_path = $this->file($id, $language_code, $type);

        if (file_exists($file_path)) {
            //Delete old file
            unlink($file_path);
        }

        //Serialize data
        $string_data = serialize($data);

        //Store data
        file_put_contents($file_path, $string_data);

        $this->debug(['stored', filemtime($file_path), time('now')]);
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

        $file_path = $this->file($id, $language_code, $type);

        if (file_exists($file_path) &&
            time('now') - filemtime($file_path) < $this->TTL) {
            $this->debug(['hit', filemtime($file_path), time('now')]);

            $data = unserialize(file_get_contents($file_path));

            return $data;
        }
        $this->debug(['miss']);
        return NULL;
    }

}
