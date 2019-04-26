# Juggler
> PHP 轻量级数据库(MySQL)框架

[使用手册](doc/guide.md)


## 要求
- PHP 版本 5.5 及以上
- 支持 PDO, 已安装扩展`pdo_mysql`


## 特性
- 常见数据库操作功能
- WHERE 组合条件万千变化
- 支持事务回调操作
- 支持分片回调处理数据
- 支持缓存查询数据
- 支持多种联表查询
- 支持多种数据绑定
- 数据安全过滤保障
- 引入、包装更简单


## 使用
通过 Composer 安装
```
$ composer require upfor/juggler
```

```
<?php

use Upfor\Juggler\Juggler;

require 'vendor/autoload.php';

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
$data = $db->table('user')->field(array('user_id', 'username'))->where('user_id|>=', 20)->getList();
echo json_encode($data);

```


## 协议
**Juggler** 遵循 **MIT** 开源协议发布，并提供免费使用。
