# Juggler使用手册


## 入门
```
// Using Juggler namespace
use Upfor\Juggler\Juggler;

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

// Insert data
$db->table('account')->insert(array(
    "username" => "name",
    "email" => "foo@example.com",
));
```


## 使用

### 基础查询/执行

#### query
    用于执行查询类SQL。

- 成功，返回查询结果；失败，返回`FALSE`。
- 支持unbuffered查询

```
/**
 * Execute an SQL statement and return the result
 *
 * @param  string  $sql
 * @param  array   $bindData
 * @param  boolean $fetch
 * @param  boolean $unbuffered
 * @return mixed
 */
public function query($sql, array $bindData = array(), $fetch = false, $unbuffered = false) {...}
```

#### exec
    用于执行非查询类SQL。

- 成功，返回影响行数；失败，返回`FALSE`。

```
/**
 * Execute an SQL statement and return the number of affected rows
 *
 * @param  string  $sql
 * @param  array   $bindData
 * @param  boolean $fetch
 * @return mixed
 */
public function exec($sql, array $bindData = array(), $fetch = false) {...}
```


### 查询
    可与`table()`、`where()`、`limit()`、`order()`、`group`等方法联合使用。

#### getList
    查询并获取多行数据

```
// SELECT * FROM `account`
$db->table('account')->getList()
```

#### getRow
    查询并获取单行数据

```
// SELECT * FROM `account` LIMIT 1
$db->table('account')->getRow();
```

#### has
    是否存在符合条件的数据

```
/**
 * Determine whether the target data existed
 *
 * @param  array $where
 * @return boolean
 */
public function has($where = array()) {...}
```

```
// SELECT EXISTS(SELECT 1 FROM `account` WHERE `id` = 12) AS `tmp`
$db->table('account')->where(array(
    'id' => 12,
))->has();
```

#### count
    统计满足条件的数据行数

```
/**
 * Counts the number of rows
 *
 * @param  string $field
 * @return integer
 */
public function count($field = '*') {...}
```

```
// SELECT COUNT(*) AS `count_total` FROM `account` WHERE `id` >= 12 LIMIT 1
$db->table('account')->where(array(
    'id|>=' => 12,
))->count();
```

#### sum
    计算符合条件数据的字段总和

```
/**
 * Get the total value for the column
 *
 * @param  string $field
 * @return integer
 */
public function sum($field) {...}
```

```
// SELECT SUM(`age`) AS `sum_total` FROM `account` WHERE `id` >= 12 LIMIT 1
$db->table('account')->where(array(
    'id|>=' => 12,
))->sum('age');
```

#### max
    查询符合条件数据的字段最大值

```
/**
 * Get the maximum value for the column
 *
 * @param  string $field
 * @return integer
 */
public function max($field) {...}
```

```
// SELECT MAX(`age`) AS `max_tmp` FROM `account` WHERE `id` >= 12 LIMIT 1
$db->table('account')->where(array(
    'id|>=' => 12,
))->sum('age');
```

#### min
    查询符合条件数据的字段最小值

```
/**
 * Get the minimum value for the column
 *
 * @param  string $field
 * @return integer
 */
public function min($field) {...}
```

```
// SELECT MIN(`age`) AS `min_tmp` FROM `account` WHERE `id` >= 12 LIMIT 1
$db->table('account')->where(array(
    'id|>=' => 12,
))->min('age');
```

#### avg
    查询符合条件数据的字段平均值

```
/**
 * Get the average value for the column
 *
 * @param  string $field
 * @return integer
 */
public function avg($field) {...}
```

```
// SELECT AVG(`age`) AS avg_tmp FROM `account` WHERE `id` >= 12 LIMIT 1
$db->table('account')->where(array(
    'id|>=' => 12,
))->avg('age');
```

#### value
    查询符合条件数据的第一行指定字段值

```
/**
 * Gets the value of a field
 *
 * @param  string $field
 * @return mixed
 */
public function value($field) {...}
```

```
// SELECT `age` FROM `account` WHERE `id` >= 12 LIMIT 1
$db->table('account')->where(array(
    'id|>=' => 12,
))->value('age');
```

#### column
    查询符合条件数据的指定字段(列)

```
/**
 * Gets the value of the specified column
 *
 * @param  string $field
 * @return array
 */
public function column($field) {...}
```

```
// SELECT `age` FROM `account` WHERE `id` >= 12
$db->table('account')->where(array(
    'id|>=' => 12,
))->column('age');
```



### 插入
    可与`table()`等方法联合使用。

#### 参数
    + 支持单条或批量插入。
    + 插入数据必须是关联数组，即元素的键名就是字段名。
    + 一维数组会被视为单条插入；二维数组会被视为批量插入；超过二维，则会对值进行自动转换成JSON字符串。
    + 支持`ON DUPLICATE KEY UPDATE`进行数据更新。

```
/**
 * Insert new data
 *
 * Support for bulk inserts, or updates while a duplicate value in a UNIQUE index or PRIMARY KEY
 *
 * @param  array   $data    The data to insert
 * @param  mixed   $replace Use sub statement `ON DUPLICATE KEY UPDATE` to replace existed data
 * @param  boolean $fetch   Is fetch the SQL statement?
 * @return integer
 */
public function insert(array $data, $replace = null, $fetch = false) {...}
```

#### 示例

- 单条插入
```
// INSERT INTO `account` (`age`, `name`) VALUES (18, 'john')
$db->table('account')->insert(array(
    'name' => 'john',
    'age' => 18,
));
```

- 批量插入

```
// INSERT INTO `account` (`age`, `name`) VALUES (18, 'john'), (20, 'mary')
$db->table('account')->insert(array(
    array(
        'name' => 'john',
        'age' => 18,
    ),
    array(
        'name' => 'mary',
        'age' => 20,
    ),
));
```

- $replace: true, 全部字段更新

```
// INSERT INTO `account` (`age`, `name`) VALUES (18, 'john'), (20, 'mary') ON DUPLICATE KEY UPDATE `age`=VALUES(`age`), `name`=VALUES(`name`)
$db->table('account')->insert(array(
    array(
        'name' => 'john',
        'age' => 18,
    ),
    array(
        'name' => 'mary',
        'age' => 20,
    ),
), true);
```

- $replace: array(var1, var2, ...), 更新指定字段

```
// INSERT INTO `account` (`age`, `name`) VALUES (18, 'john'), (20, 'mary') ON DUPLICATE KEY UPDATE `name`=VALUES(`name`)
$db->table('account')->insert(array(
    array(
        'name' => 'john',
        'age' => 18,
    ),
    array(
        'name' => 'mary',
        'age' => 20,
    ),
), array('name'));
```

- $replace: string, 原生SQL子句

```
// INSERT INTO `account` (`age`, `name`) VALUES (18, 'john'), (20, 'mary') ON DUPLICATE KEY UPDATE `age`=VALUES(`age`) + 1
$db->table('account')->insert(array(
    array(
        'name' => 'john',
        'age' => 18,
    ),
    array(
        'name' => 'mary',
        'age' => 20,
    ),
), '`age`=VALUES(`age`) + 1');
```


### 修改
    可与`table()`、`where()`、`limit()`、`order()`等方法联合使用。

#### 参数
```
/**
 * Update data
 *
 * @param  array   $data
 * @param  array   $where
 * @param  mixed   $table
 * @param  boolean $fetch
 * @return integer
 */
public function update(array $data, array $where = array(), $table = null, $fetch = false) {...}
```

#### 示例
```
// UPDATE `account` SET `name` = 'hello', `age` = 12 WHERE `id` = 108
$db->table('account')->where(array(
    'id' => 108,
))->update(array(
    'name' => 'hello',
    'age' => 12,
));

// UPDATE `account` SET `name` = 'hello', `age` = 12 WHERE `id` = 108
$db->update(array(
    'name' => 'hello',
    'age' => 12,
), array(
    'id' => 108,
), 'account');
```


### 删除
可与`table()`、`where()`、`limit()`、`order()`等方法联合使用。

#### 参数
```
/**
 * Conditionally delete data
 *
 * @param  array   $where
 * @param  mixed   $table
 * @param  boolean $fetch
 * @return integer
 */
public function delete(array $where = array(), $table = null, $fetch = false) {...}
```

#### 示例
```
// DELETE FROM `account` WHERE `gid` IN (1, 2, 3)
$db->table('account')->where(array(
    'gid' => array(1, 2, 3),
))->delete();

// DELETE FROM `account` WHERE `gid` IN (1, 2, 3)
$db->delete(array(
    'gid' => array(1, 2, 3),
), 'account');
```


### WHERE
    Juggler 最核心、最强大的功能。支持多层级、多类型、多组合的WHERE查询条件表达式。

#### 参数
```
/**
 * Sets the `WHERE` statement
 *
 * @see    Function `buildWhere`
 * @access protected
 * @param  mixed $condition Supports a variety of formats
 * @param  mixed $value     The value of condition
 * @return Juggler
 */
public function where($condition, $value = null) {
    if (is_string($condition)) {
        if (!is_null($value)) {
            $this->options['where'][$condition] = $value;
        } else {
            $this->options['where']['SQL'] = $condition;
        }
    } elseif (is_array($condition)) {
        if (isset($this->options['where']) && is_array($this->options['where'])) {
            $this->options['where'] = array_merge($this->options['where'], $condition);
        } else {
            $this->options['where'] = $condition;
        }
    }

    return $this;
}
```

`$condition`: 支持单一字段, 复杂SQL, 多维数组, 复杂的条件表达式等
`$value`: 当`$condition`作为数组类型的参数时, 无效

```
// SELECT * FROM `account` WHERE `id` = 12
$db->table('account')->where('id', 12)->getList();

// SELECT * FROM `account` WHERE `id` != 12
$db->table('account')->where('id|!', 12)->getList();

// SELECT * FROM `account` WHERE MOD(`id`, 15) > 12
$db->table('account')->where('MOD(`id`, 15)|>', 12)->getList();

// SELECT * FROM `account` WHERE `id` > 12 AND `status` = 1
$db->table('account')->where('`id` > 12 AND `status` = 1')->getList();

// SELECT * FROM `account` WHERE (`id` BETWEEN 100 AND 200) AND `avatar` IS NOT NULL AND `gid` IN (1, 3, 5) AND `username` LIKE 'john%' AND `age` = 16
$db->table('account')->where(array(
    'id|<>' => array(100, 200),
    'avatar|!' => null,
    'gid' => array(1, 3, 5),
    'username|~' => 'john%',
    'SQL' => '`age` = 16',
))->getList();
```

#### 操作符
支持用中竖线`|`进行分隔操作符, 以实现复杂的条件语句.
支持的条件操作符: !, >, >=, <, <=, <>, ><, ~, !~

- 无操作符 (`=`, `IN`, `IS NULL`)
```
// SELECT * FROM `account` WHERE `id` = 12
$db->table('account')->where('id', 12)->getList();

// SELECT * FROM `account` WHERE `status` = 0
$db->table('account')->where('status', false)->getList();

// SELECT * FROM `account` WHERE `id` IN (1, 3, 5)
$db->table('account')->where('id', array(1, 3, 5))->getList();

// SELECT * FROM `account` WHERE `avatar` IS NULL
$db->table('account')->where(array(
    'avatar' => null,
))->getList();
```

- `!` (`!=`, `NOT IN`, `IS NOT NULL`)
```
// SELECT * FROM `account` WHERE `id` != 12
$db->table('account')->where('id|!', 12)->getList();

// SELECT * FROM `account` WHERE `id` NOT IN (1, 3, 5)
$db->table('account')->where('id|!', array(1, 3, 5))->getList();

// SELECT * FROM `account` WHERE `avatar` IS NOT NULL
$db->table('account')->where(array(
    'avatar|!' => null,
))->getList();
```

- `<>`、`><` (`BETWEEN`, `NOT BETWEEN`)
```
// SELECT * FROM `account` WHERE `id` BETWEEN 100 AND 300
$db->table('account')->where(array(
    'id|<>' => array(100, 300),
))->getList();

// SELECT * FROM `account` WHERE `id` NOT BETWEEN 100 AND 300
$db->table('account')->where(array(
    'id|><' => array(100, 300),
))->getList();
```

- `~`、`!~` (`LIKE`, `NOT LIKE`)
```
// SELECT * FROM `account` WHERE `url` LIKE '%qq.com%'
$db->table('account')->where(array(
    'url|~' => 'qq.com',
))->getList();

// SELECT * FROM `account` WHERE `url` LIKE '%qq.com'
$db->table('account')->where(array(
    'url|~' => '%qq.com',
))->getList();

// SELECT * FROM `account` WHERE `url` LIKE 'qq.com%'
$db->table('account')->where(array(
    'url|~' => 'qq.com%',
))->getList();

// SELECT * FROM `account` WHERE `url` NOT LIKE '%qq.com%'
$db->table('account')->where(array(
    'url|!~' => 'qq.com',
))->getList();

// SELECT * FROM `account` WHERE `url` NOT LIKE '%qq.com%' OR `url` NOT LIKE '%taobao.com%'
$db->table('account')->where(array(
    'url|!~' => array('qq.com', 'taobao.com'),
))->getList();
```

#### 组合
目前，支持`AND`、`OR`、`SQL`3种组合语句。3种组合可以任意嵌套、组合使用。

- `AND`
对于数组，默认组合方式为`AND`，故可省略。
一级条件，均为`AND`组合。

```
// SELECT * FROM `account` WHERE `username` = 'hello' AND `age` > 10
$db->table('account')->where(array(
    'username' => 'hello',
    'age|>' => 10,
))->getList();

// SELECT * FROM `account` WHERE `username` = 'hello' AND `age` > 10
$db->table('account')->where(array(
    array(
        'username' => 'hello',
        'age|>' => 10,
    ),
))->getList();

// SELECT * FROM `account` WHERE (`id` >= 12 OR `avatar` IS NOT NULL) AND `gid` IN (1, 2, 3) AND `sql` = 123 AND (`username` = 'hello' AND `age` > 10)
$db->table('account')->where(array(
    'OR' => array(
        'id|>=' => 12,
        'avatar|!' => null,
    ),
    'gid' => array(1, 2, 3),
    'SQL' => '`sql` = 123',
    array(
        'username' => 'hello',
        'age|>' => 10,
    ),
))->getList();
```

- `OR`
使用`OR`组合，可实现`WHERE`条件语句中的`OR`。

```
// SELECT * FROM `account` WHERE (`id` >= 12 OR `avatar` IS NOT NULL) AND `gid` IN (1, 2, 3) AND (`username` = 'hello' AND `age` > 10)
$db->table('account')->where(array(
    'OR' => array(
        'id|>=' => 12,
        'avatar|!' => null,
    ),
    'gid' => array(1, 2, 3),
    array(
        'username' => 'hello',
        'age|>' => 10,
    ),
))->getList();
```

- `SQL`
使用`SQL`组合，可实现原生SQL语句。
`SQL`组合可直接使用字符串类型的参数传入`where()`方法。

```
// SELECT * FROM `account` WHERE `id` >= 100 AND `username` LIKE '%john%'
$db->table('account')->where("`id` >= 100 AND `username` LIKE '%john%'")->getList();

// SELECT * FROM `account` WHERE (`id` >= 12 OR `money` > 41) AND `gid` IN (1, 2, 3) AND `sql` = 123 AND (`username` = 'hello' AND `age` > 10)
$db->table('account')->where(array(
    'OR' => array(
        'id|>=' => 12,
        'SQL' => '`money` > 41',
    ),
    'gid' => array(1, 2, 3),
    'SQL' => '`sql` = 123',
    array(
        'username' => 'hello',
        'age|>' => 10,
    ),
))->getList();
```


### 功能
#### dbname
    设置数据库名称

#### distinct
    设置`DISTINCT`子句

#### field
    指定查询的字段

- 支持字符串、数组、数值等
- 支持字段别名
- 对于普通字段，建议使用数据
- 支持字段运算表达式

```
// SELECT RAND() AS `rand_str` FROM `account`
$db->table('account')->field(array(
    'rand_str' => 'RAND()',
))->getList();

// SELECT RAND() AS `rand_str`, `username`, `age` * `score` AS `weight` FROM `account`
$db->table('account')->field(array(
    'rand_str' => 'RAND()',
    'username',
    'weight' => '`age` * `score`',
))->getList();

// 直接传入原生SQL子句
// SELECT `username`, `age`, `age` * `score` AS `weight` FROM `account`
$db->table('account')->field('`username`, `age`, `age` * `score` AS `weight`')->getList();
```

#### table
    指定查询的表名

- 支持别名、前缀
- 支持数组形式传参
- 数据库配置有前缀，则可用统一的前缀

```
/**
 * Sets the table name for current statement
 *
 * @param  mixed   $table  Table name
 * @param  string  $alias  Table alias
 * @param  boolean $prefix The prefix of table name
 * @return Juggler
 */
public function table($table, $alias = null, $prefix = false) {...}
```

```
// SELECT * FROM `account`
$db->table('account')->getList();

// 别名
// SELECT * FROM `account` AS `a`
$db->table('account', 'a')->getList();

// 数组形式传参
// SELECT * FROM `account` AS `a`
$db->table(array('account', 'a'))->getList();

// 指定表前缀
// SELECT * FROM `pre_account` AS `a`
$db->table('account', 'a', 'pre_')->getList();

// 使用数据库配置统一表前缀
// SELECT * FROM `db_pre_account` AS `a`
$db->table('account', 'a', true)->getList();
```

#### order
    指定排序方式

- 支持多字段排序
- 支持数组传参

```
/**
 * Sets the `ORDER BY` statement
 *
 * @param  string|array $field Field name, supports multiple definitions
 * @param  string       $order ASC or DESC, not case-sensitive
 * @return Juggler
 */
public function order($field, $order = null) {...}
```

```
// SELECT * FROM `account` ORDER BY `id`
$db->table('account')->order('id')->getList();

// SELECT * FROM `account` ORDER BY `id` DESC
$db->table('account')->order('id', 'DESC')->getList();

// SELECT * FROM `account` ORDER BY `id` DESC, `age` ASC
$db->table('account')->order(array(
    'id' => 'DESC',
    'age' => 'ASC',
))->getList();
```

#### group
    指定`GROUP BY`聚合子句

- 支持多字段聚合
- 支持聚合排序

```
/**
 * Sets the `GROUP BY` statement
 *
 * @param  string|array $group
 * @param  string       $order ASC or DESC, not case-sensitive
 * @return $this
 */
public function group($group, $order = null) {...}
```

```
// SELECT * FROM `account` GROUP BY `id`, `age`
$db->table('account')->group(array(
    'id',
    'age',
))->getList();

// SELECT * FROM `account` GROUP BY `id` ASC
$db->table('account')->group('id', 'asc')->getList();
var_dump($data);

// SELECT * FROM `account` GROUP BY `id` DESC, `age` ASC
$db->table('account')->group(array(
    'id' => 'DESC',
    'age' => 'ASC',
))->getList();

// 原生SQL子句
// SELECT * FROM `account` GROUP BY year ASC, country ASC, product ASC WITH ROLLUP
$db->table('account')->group('year ASC, country ASC, product ASC WITH ROLLUP')->getList();
```

#### limit
    设置`LIMIT`子句

```
/**
 * Sets the `LIMIT` statement
 *
 * @param  integer|string $offset
 * @param  integer        $length
 * @return Juggler
 */
public function limit($offset, $length = null) {...}
```

```
// SELECT * FROM `account` LIMIT 5
$db->table('account')->limit(5)->getList();

// SELECT * FROM `account` LIMIT 11, 10
$db->table('account')->limit(11, 10)->getList();
```

#### page
    设置分页参数，转换为`LIMIT`子句

```
/**
 * Sets the page of the data
 * A more vivid way of get range values
 *
 * @param  integer|string $page     Page number
 * @param  integer        $listRows Page size
 * @return Juggler
 */
public function page($page, $listRows = null) {...}
```

```
// SELECT * FROM `account` LIMIT 100, 10
$db->table('account')->page(11, 10)->getList();
```

#### join
    联表查询`JOIN`子句

```
/**
 * @param  string|array $table     Join table(s)
 * @param  string|array $condition Join conditions
 * @param  string       $type      Join type
 * @param  boolean      $prefix    The prefix of table name
 * @return Juggler
 */
public function join($table, $condition, $type = 'LEFT', $prefix = false) {...}
```

```
// SELECT * FROM `account` AS `A` LEFT JOIN `money` AS `M` ON `M`.`account_id` = `A`.`id`
$db->table('account', 'A')->join(['money', 'M'], ['M.account_id' => 'A.id'])->getList();
```

#### escape
    设置是否对字段、表名、数据库名等进行包裹。系统默认会进行智能包裹。

#### indexBy
    设置 `getList()` 数据集的索引方式。支持按字段名或自定义进行索引。

```php
$db->table('country')->indexBy('code')->getList();

// 或者:
$data = $db->table('country')->indexBy(function ($row) {
    return $row['code'];
})->getList();

// Output:
Array
(
    [AU] => Array
        (
            [code] => AU
            [name] => Australia
            [population] => 18886000
        )

    [BR] => Array
        (
            [code] => BR
            [name] => Brazil
            [population] => 170115000
        )
)
```

#### fetch
    设置是否返回解析完成后的SQL语句。一般用于调试。

#### getQueryLog
    获取SQL执行日志

#### errorInfo
    获取最后一条SQL执行错误信息

#### lastInsertId
    获取最后一条SQL产生的插入ID

#### chunk
    分块/分批处理数据

#### unbufferedQuery
    缓冲式查询SQL

#### getFields
    获取表的字段信息

#### getTables
    获取数据库所有数据表

#### getServerInfo
    获取数据库服务器&连接信息



### 事务

#### beginTransaction
    开始事务

#### commit
    提交事务

#### rollBack
    回滚事务

#### inTransaction
    是否处于事务状态

#### action
    回调形式执行事务

