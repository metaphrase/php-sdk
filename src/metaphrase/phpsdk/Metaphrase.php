<?php

namespace metaphrase\phpsdk;

use metaphrase\phpsdk\MetaphraseException;

/**
 * Metaphrase class
 * 
 * Create a new instance of this class by providing your authentication credentials
 * And execute the available API methods
 * 
 * <strong>Currently uses old translate API</strong>
 * @author Spafaridis Xenophon <nohponex@gmail.com>
 * @package metaphrase
 * @subpackage phpsdk
 * @copyright TBA
 * @version 005
 * @uses curl_init curl
 * @copyright (c) 2014-2015, Spafaridis Xenophon
 * @todo Migrate to metaphrase api
 * @todo Make sure it can be work as a script in order to assist other SDKs to download and cache the translated data
 */
class Metaphrase {

    const VERSION = '0.0.5';
    const VERSION_INTEGER = 005;
    const METHOD_GET = 'GET';
    const METHOD_HEAD = 'HEAD';
    const METHOD_POST = 'POST';
    const METHOD_DELETE = 'DELETE';
    const METHOD_PUT = 'PUT';
    const REQUEST_EMPTY_FLAG = 0;
    const REQUEST_BINARY = 1;
    const REQUEST_NOT_URL_ENCODED = 2;

    /**
     * Setting CURLOPT_CONNECTTIMEOUT - timeout for the connect phase 
     * Pass a long. It should contain the maximum time in seconds that you allow
     * the connection phase to the server to take.
     * This only limits the connection phase, it has no impact once it has connected.
     * Set to zero to switch to the default built-in connection timeout - 300 seconds.
     * Default timeout is 300. 
     * @see CURLOPT_CONNECTTIMEOUT
     * @var integer
     */
    const SETTING_CURLOPT_CONNECTTIMEOUT = CURLOPT_CONNECTTIMEOUT;

    /**
     * Setting CURLOPT_TIMEOUT - set maximum time the request is allowed to take
     * 
     * Pass a long as parameter containing timeout - the maximum time in seconds
     * that you allow the libcurl transfer operation to take.
     * Normally, name lookups can take a considerable time and limiting operations
     * to less than a few minutes risk aborting perfectly normal operations.
     * This option may cause libcurl to use the SIGALRM signal to timeout system calls. 
     * Default timeout is 0 (zero) which means it never times out during transfer.
     * @see CURLOPT_TIMEOUT
     * @var integer
     */
    const SETTING_CURLOPT_TIMEOUT = CURLOPT_TIMEOUT;

    /**
     * SDK settings
     * @var array
     */
    private $settings = [
        self::SETTING_CURLOPT_CONNECTTIMEOUT => 300,
        self::SETTING_CURLOPT_TIMEOUT => 0
    ];

    /**
     * Base url of Metaphrase API
     */
    private $API_URL = 'https://translate.nohponex.gr/';
    private $authentication_credentials = FALSE;
    private $authentication_header = FALSE;
    public $keyword;

    /**
     * Project's API KEY
     */
    private $api_key;
    private $cache_engine = NULL;

    /**
     * Create a new instance of the class using user's email and password
     * as authentication credentials
     * @param string $api_key Your API KEY
     * @param array $settings
     * @return Returns an instance of Translate
     */
    public function __construct($api_key, $settings = [], $cache_engine = TRUE) {
        //Set API key
        $this->api_key = $api_key;

        //Copy settings
        foreach ($settings as $key => $value) {
            if (isset($this->settings[$key])) {
                $this->settings[$key] = $value;
            }
        }

        //Setup controllers
        $this->keyword = new \metaphrase\phpsdk\controllers\Keyword();
        $this->project = new \metaphrase\phpsdk\controllers\Project();

        //Setup cache machine
        if ($cache_engine !== NULL) {

            //Check if extends interface
            if (!is_subclass_of($cache_engine, 'metaphrase\phpsdk\ICache', TRUE)) {
                throw new \Exception('metaphrase\phpsdk\ICache');
            }
            $this->cache_engine = $cache_engine;
        }
    }

    /**
     * Perform an cURL request to API server,
     * this is an internal function
     * @param string $resource Resource fraction of the url for example fetch/?name=xx 
     * @return array Returns an array with the response code and the response,
     * if the accept parameter is set to json the the response will be decoded as json
     */
    private function request($resource, $method = self::METHOD_GET, $data = NULL, $flags = self::REQUEST_EMPTY_FLAG, $accept = 'application/json', $encoding = NULL) {

        //Construct request url
        $url = $this->API_URL . $resource . '&api_key=' . $this->api_key;

        //Extract flags
        //Is the request binary
        $binary = ( $flags & self::REQUEST_BINARY ) != 0;
        //If the request paramters form encoded
        $form_encoded = !(( $flags & self::REQUEST_NOT_URL_ENCODED ) != 0);

        //Initialize headers
        $headers = array(
            'Accept: ' . $accept,
            /* $this->authentication_header */
        );

        //If request's data is encoded provide the Contenty type Header
        if ($form_encoded) {
            $headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8';
        }

        //If request has a special Content-Encoding
        if ($encoding) {
            $headers[] = 'Content-Encoding: ' . $encoding;
        }

        //Initialize curl
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
        //Set timeout values ( in seconds )
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, $this->settings[self::SETTING_CURLOPT_CONNECTTIMEOUT]);
        curl_setopt($handle, CURLOPT_TIMEOUT, $this->settings[self::SETTING_CURLOPT_TIMEOUT]);
        curl_setopt($handle, CURLOPT_NOSIGNAL, 1);

        //Security options
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE);

        //On binary transfers
        if ($binary) {
            curl_setopt($handle, CURLOPT_BINARYTRANSFER, TRUE);
        }

        //Switch on HTTP Request method
        switch ($method) {
            case self::METHOD_GET : //On METHOD_GET 
            case self::METHOD_HEAD : //On METHOD_HEAD 
                break;
            case self::METHOD_POST : //On METHOD_POST
                curl_setopt($handle, CURLOPT_POST, true);

                if ($data && $form_encoded) { //Encode fields if required ( URL ENCODED )
                    curl_setopt(
                        $handle, CURLOPT_POSTFIELDS, http_build_query($data));
                } else if ($data) {
                    curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
                }
                break;
            case self::METHOD_PUT : //On METHOD_PUT
                curl_setopt($handle, CURLOPT_CUSTOMREQUEST, self::METHOD_PUT);
                if ($data) {
                    curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($data));
                }
                break;
            case self::METHOD_DELETE : //On METHOD_DELETE
                curl_setopt($handle, CURLOPT_CUSTOMREQUEST, self::METHOD_DELETE);
                break;
            default:
                throw new MetaphraseException('Unsupporter method');
        }

        //Get response
        $response = curl_exec($handle);
        //Get response code
        $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

        //Catch curl error
        if (!$response) {
            //Throw a MetaphraseException
            throw new MetaphraseException('Error: "' . curl_error($handle));
        }

        //Throw exception on responce failure
        if (!in_array($code, array(200, 201, 202))) { // OK, Created, Accepted
            $decoded = json_decode($response, true);

            throw new MetaphraseException($decoded['error'], $code);
        }

        curl_close($handle);

        //Return the data of response
        return (
            $accept == 'application/json' ? json_decode($response, true) : $response );
    }

    /**
     * SDK Public Methods section
     */

    /**
     * Get all translation keys
     * @throws MetaphraseException on failure
     * @param integer $project_id Project's id
     * @param string $language_code Lanuage Code
     * @param boolean $use_cached [Optional] If true, the SDK will attempt to use the selected cache machine. Default TRUE
     * @return array Returns translation array for selected language
     */
    public function fetch($project_id, $language_code, $use_cached = TRUE) {

        $use_cached &= $this->cache_engine !== NULL;
        //Use cached
        if ($use_cached) {
            $cached = $this->cache_engine->fetch($project_id, $language_code);

            if ($cached !== NULL) {
                return $cached;
            }
        }

        $p = array('id' => $project_id, 'language' => $language_code);

        $r = $this->request(( 'fetch/listing?' . http_build_query($p)), self::METHOD_GET);

        if ($use_cached && $r && isset($r['translation'])) {
            $this->cache_engine->store($project_id, $language_code, $r['translation']);
        }

        return $r['translation'];
    }

    /**
     * Add keyword to a project
     * @throws MetaphraseException on failure
     * @param integer $project_id Project's id
     * @param string $keyword Keyword
     * @return boolean Returns TRUE on success
     */
    public function add_key($project_id, $keyword) {

        $p = array('id' => $project_id, 'key' => $keyword);

        try {
            $r = $this->request('fetch/create?', self::METHOD_POST, $p);
        } catch (MetaphraseException $e) {
            //Key exists
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Cache helper task
     * 
     * @param type $project_id
     * @param type $language_code
     */
    public static function cache_update($project_id, $language_code) {
        throw new \Exception('not implemented');
    }

    /**
     * Cache helper task
     * 
     * @param type $project_id
     * @param type $language_code
     */
    public static function cache_clear($project_id, $language_code) {
        throw new \Exception('not implemented');
    }

}
