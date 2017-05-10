<?php

use Upfor\Juggler\Juggler;

require '../vendor/autoload.php';

// Config and connect server
$config = array(
    'host' => '127.0.0.1',
    'port' => 3306,
    'dbname' => 'upfor_nav',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8',
    'prefix' => 'db_pre_',
);
$db = new Juggler($config);
$db->fetch();

$data = $db->table('account', 'A')->join(['money', 'M'], ['M.account_id' => 'A.id'])->getList();
var_dump($data);
die;

$db->table('admin_auth_node');
$db->where([
    'node_id|>' => '?',
    //'RAND()' => 1,
]);
//$db->field('`A`.`name`, B.*,C.id , oisd');
//$db->field(23423);
//$db->order('node_id', 'desc');
//$db->limit(1);
$db->bind(0, 1);
//$db->distinct(1);
//$db->fetch();
//$data = $db->delete();
//$data = $db->column('title');
//$data = $db->has();
//$data = $db->count(1);
//$data = $db->sum(2.5);
//$data = $db->max('node_id');
//$data = $db->min('node_id');
//$data = $db->avg('12');
//$data = $db->update($config);
//$data = $db->getList();
//$data = $db->value('node_id AS id');
//$data = $db->value('title');
//$data = $db->value('CONNECTION_ID()');
//$data = $db->max('node_id');
//$data = $db->getTables();
var_dump($data);
var_dump($db->getQueryLog());
//var_dump($db->errorInfo());
die;

// Condition demos
$where = [
    'ref.role_id|>=' => '?',
    //'url|~' => ':url',
];

$db->where($where);
//$db->escape(false);
$db->table('admin_auth_role_node', 'ref');
$db->join(['admin_auth_node', 'node'], ['node.node_id + 1 * 5' => 'ref.node_id']);
//$db->field(['ref.*', 'node.title']);
$db->field('A.name, B.*,C.id , oisd');
//$db->field(array('site_id', 'name', 'url' => 'site_url'));
//$db->order('site_id', 'DESC');
$db->order('ref.id');
$db->group('id');
$db->group('user');
$db->limit(1);
//$db->bind('url', '%baidu%');
$db->bind(0, 1);
$data = $db->getList(true);
var_dump($data);

