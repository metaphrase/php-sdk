<?php

namespace metaphrase\phpsdk;

/**
 * Metaphrase exception class
 * @license http://www.gnu.org/licenses/lgpl-2.1.html LGPL License 2.1
 * @copyright (c) 2014-2015, Spafaridis Xenophon
 * @author Spafaridis Xenophon <nohponex@gmail.com>
 * @package metaphrase
 * @subpackage phpsdk
 */
class MetaphraseException extends \Exception {

    public function __construct($error, $code = 400) {
        parent::__construct($error, $code);
    }

}
