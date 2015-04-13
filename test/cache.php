<?php

/**
 * Demo
 */
//Or replace your path to vendor
require '../vendor/autoload.php';

print "\n\nMETAPHRASE TEST\nVersion: " . metaphrase\phpsdk\Metaphrase::VERSION . "\n\n";

$settings = [
    'API_KEY' => '614a98a31bd17b3a82094ef0388b9d81',
    'language_code' => 'en',
    'project_id' => 19
];

try {
    $cache_machine = new metaphrase\phpsdk\cache\Simple();

    //Initialize Metaphrase class
    $metaphrase = new metaphrase\phpsdk\Metaphrase($settings['API_KEY'], [
        metaphrase\phpsdk\Metaphrase::SETTING_CURLOPT_CONNECTTIMEOUT => 0
        ], $cache_machine);

    //Fetch translated keys
    $translated = $metaphrase->fetch(
        $settings['project_id'], $settings['language_code']);

    print_r($translated);

    //Refetch
    $translated = $metaphrase->fetch(
        $settings['project_id'], $settings['language_code']);

    print_r($translated);
} catch (metaphrase\phpsdk\MetaphraseException $e) {
    print( $e->getMessage());
    die();
}

