<?php

namespace metaphrase\phpsdk;

/**
 *
 * @author Spafaridis Xenophon <nohponex@gmail.com>
 * @package metaphrase
 * @subpackage phpsdk
 * @todo Work in progress
 */
interface ICache {

    public function store($id, $language_code, $data);

    public function fetch($id, $language_code);
}
