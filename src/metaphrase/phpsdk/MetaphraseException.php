<?php
namespace metaphrase\phpsdk;

class MetaphraseException extends \Exception {

    public function __construct($error, $code = 400) {
        parent::__construct($error, $code);
    }

}