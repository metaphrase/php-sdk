#!/usr/bin/php
<?php
/**
 * Demo
 */
//Or replace your path to vendor
require __DIR__ . '/../vendor/autoload.php';

print "\n\nMETAPHRASE TEST\nVersion: " . metaphrase\phpsdk\Metaphrase::VERSION . "\n\n";

$settings = [
    'API_KEY' => '614a98a31bd17b3a82094ef0388b9d81',
    'language_code' => 'gr',
    'project_id' => 19
];

try {
    $cache_machine = new metaphrase\phpsdk\cache\File(
        __DIR__ . '/file', 'phparray', 30, FALSE
    );
    
    //Initialize Metaphrase class
    $metaphrase = new metaphrase\phpsdk\Metaphrase($settings['API_KEY'], [
        metaphrase\phpsdk\Metaphrase::SETTING_CURLOPT_CONNECTTIMEOUT => 0
        ], $cache_machine);

    //Fetch translated keys
    $translated = $metaphrase->fetch(
        $settings['project_id'], $settings['language_code']);

    //Refetch
    $translated = $metaphrase->fetch(
        $settings['project_id'], $settings['language_code']);
} catch (metaphrase\phpsdk\MetaphraseException $e) {
    print( $e->getMessage());
    die();
}

print_r($translated);
