# Juggler
> PHP lightweight database (MySQL) framework

[中文介绍](README_ZH.md)


## Main Features
- Common database operation functions
- WHERE combination conditions vary
- Supports transaction callback operations
- Support for split - sheet callback processing data
- Supports cache query data
- Supports multiple table queries
- Support multiple data bindings
- Data security filtering guarantee
- Introduction, packaging is easier


## Requirement
- PHP 5.5+
- Support the PDO, extension `pdo_mysql` installed


## Get Started

Install via composer
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


## License
**Juggler** is under the **MIT** license.
