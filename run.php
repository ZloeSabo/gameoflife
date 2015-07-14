#!/usr/bin/env php
<?php
/**
 * Created by Evgeny Soynov <saboteur@saboteur.me> .
 */

defined('DS')
    || define('DS', DIRECTORY_SEPARATOR)
;

require __DIR__ . DS . '/vendor/' . DS . 'autoload.php';

use GameOfLife\Application;

$application = new Application();
$application->run();