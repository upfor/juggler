<?php

use Upfor\Juggler\Juggler;

require dirname(__DIR__) . '/src/Juggler.php';

// Config and connect server
$config = array(
    'host' => '127.0.0.1',
    'port' => 3306,
    'dbname' => 'db_name',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8',
    'prefix' => '',
);
$db = new Juggler($config);

// SELECT `user_id`, `username` FROM `user` WHERE `user_id` >= 20
$data = $db->table('user')->field(array('user_id', 'username'))->where('user_id|>=', 20)->getList();
echo json_encode($data);
