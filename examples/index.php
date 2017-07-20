<?php

use Upfor\Juggler\Juggler;

require '../vendor/autoload.php';

// Config and connect server
$config = array(
    'host' => '127.0.0.1',
    'port' => 3306,
    'dbname' => 'db_name',
    'username' => 'your_username',
    'password' => 'your_password',
    'charset' => 'utf8',
    'prefix' => 'db_pre_',
);
$db = new Juggler($config);

// SELECT `user_id`, `username` FROM `user` WHERE `user_id` >= 20
$data = $db->table('user')->fetch()->field(['user_id', 'username'])->where('user_id|>=', 20)->getList();
echo json_encode($data);

