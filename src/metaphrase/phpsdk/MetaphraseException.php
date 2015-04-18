<?php

namespace metaphrase\phpsdk;

/**
 * Metaphrase exception class
 * @author Spafaridis Xenophon <nohponex@gmail.com>
 * @package metaphrase
 * @subpackage phpsdk
 */
class MetaphraseException extends \Exception {

    public function __construct($error, $code = 400) {
        parent::__construct($error, $code);
    }

}
