#!/usr/bin/env bash

apigen generate -s src -d doc  --template-theme bootstrap --todo --tree --deprecated --no-source-code --title "metaphrase/php-sdk"

#php vendor/bin/apigen