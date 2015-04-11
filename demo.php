<?php

require 'vendor/autoload.php';

$settings = [
    'API_KEY' => '614a98a31bd17b3a82094ef0388b9d81',
    'language_code' => 'en',
    'project_id' => 2222
];

try{
$metaphrase = new metaphrase\phpsdk\Metaphrase($settings['API_KEY']);

$translated = $metaphrase->fetch(
    $settings['project_id'], $settings['language_code']);

}catch(metaphrase\phpsdk\MetaphraseException $e){
    print( $e->getMessage( ) );
    die();
}
print_r($translated);
