# php-sdk
SDK for PHP5

Composer package

Requirents
-----------
* Requires composer

Installation
-----------
At your composer.json file include:

```json
"repositories": [
        { "type": "vcs", "url": "git@github.com:metaphrase/php-sdk.git" }
    ],
    "require": {
        "php": ">=5.5",
        "lib-curl": ">=7.35.0",
        "ext-pdo": ">=1.0.0",
        "ext-pdo_pgsql": ">=1.0.2",
        "ext-json": ">=1.3.6",
        "metaphrase/php-sdk": "dev-master"
    },
```

then run `composer update`

Code usage
-----------

```php
<?php

//Or replace your path to vendor
require 'vendor/autoload.php';

$settings = [
    'API_KEY' => 'xxxxxxxxxxxxxxxxxxxx',
    'language_code' => 'en',
    'project_id' => 1
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
```

