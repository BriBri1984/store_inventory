#!/usr/bin/php
<?php

$path        = dirname(__DIR__) . '/devops/roles/xdebug/files/';
$enabledFile = $path . 'xdebug-enabled.ini';
$defaultFile = $path . 'xdebug.ini';

$toggle = isset($argv[1]) && !empty($isEnabled = $argv[1]) ? filter_var($isEnabled, FILTER_VALIDATE_BOOLEAN) : true;

$file = $toggle === false ? $defaultFile : $enabledFile;
exec("sudo cp $file /etc/php/7.0/fpm/conf.d/20-xdebug.ini");
exec("sudo cp $file /etc/php/7.0/cli/conf.d/20-xdebug.ini");
exec('sudo service php7.0-fpm restart');

if ($toggle) {
    echo 'XDebug has been turned ON!' . "\n";
} else {
    echo 'XDebug has been turned OFF!' . "\n";
}