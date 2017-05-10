<?php
// Here you can initialize variables that will be available to your tests

defined('ROOT_DIR') || define('ROOT_DIR', dirname(dirname(__DIR__)));

require ROOT_DIR . '/vendor/autoload.php';

use Upfor\Juggler\Juggler;

function config() {
    return array(
        'host' => '127.0.0.1',
        'port' => 3306,
        'dbname' => 'juggler',
        'username' => 'root',
        'password' => 'root',
        'charset' => 'utf8',
        'prefix' => 'p_',
    );
}

/**
 * Database instance
 *
 * @return Juggler
 */
function db() {
    static $db;
    if (!$db) {
        $db = new Juggler(config());
    }

    return $db;
}
