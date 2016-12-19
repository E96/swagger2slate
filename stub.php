#!/usr/bin/env php
<?php

if (!version_compare(PHP_VERSION, '5.5.0', '>=')) {
    die("Php minimum version is 5.5\n");
}

if (class_exists('Phar')) {
    Phar::mapPhar('default.phar');
    require 'phar://' . __FILE__ . '/index.php';
}
__HALT_COMPILER(); ?>
