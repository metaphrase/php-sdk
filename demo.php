<?php
/**
 * Demo
 */

//Or replace your path to vendor
require 'vendor/autoload.php';

$settings = [
    'API_KEY' => '614a98a31bd17b3a82094ef0388b9d81',
    'language_code' => 'en',
    'project_id' => 19
];

try {
    //Initialize Metaphrase class
    $metaphrase = new metaphrase\phpsdk\Metaphrase($settings['API_KEY'], [
        metaphrase\phpsdk\Metaphrase::SETTING_CURLOPT_CONNECTTIMEOUT => 0
    ]);
    
    //Fetch translated keys
    $translated = $metaphrase->fetch(
        $settings['project_id'], $settings['language_code']);
    
} catch (metaphrase\phpsdk\MetaphraseException $e) {
    print( $e->getMessage());
    die();
}
print_r($translated);
