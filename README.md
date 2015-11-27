# PHP Framework. follower/core. 
## Overview
 
Framework core build as composer module (https://getcomposer.org/).
 
## index.php

```php
<?php

require_once('vendor/autoload.php');
require_once('config.php');

$project = new \MyProject\EntryPoint\Site();
$project->init();
```


## config.php

```php
\Core\Config::setDb('default', [
  'host' => '192.168.0.1',
  'name' => ‘dbname’,
  'user' => 'user',
  'password' => 123456,
  'charset' => 'utf8'
]);

Config::registerProject('MyProject', 'default');
```


## composer.json

```json
{
  "require": {
    "follower/core": "dev-master"
  },
  "autoload": {
    "classmap": [
      "vendor/follower/core/backend",
      "app"
    ]
  }
}
```

“app” - is your app folder.
Recommended backend project structure:

Api/
Controller/
Service/
EntryPoint/
Object/
Routes/


## Controller/API:

In “Api” and “Controller” folders there are controllers for different application entry points (i.e. api.php and index.php).

Here are classes with methods like methodGet, methodList, which using Orm, OrmMapper,  ActiveRecord, or Service for data processing.

```php
class Entry extends Api
{
  public function methodGet($args)
  {
    $entry = \MyProject\Object\Entry::find($args[‘id’]);
    return $entry->getValues();
  }
}
```

## Services

In “Service” folders there are service providers.
You should write business logic there (not in models and controllers).
Controllers are for output, models are for logic regarding only its attributes.
 
```php
class UserProvider
{
   public function getUsersWithPermissions($permissions)
   {
  return \MyProject\Object\User::all()
    ->addFilter(‘permissions.alias’’, $permissions)
    ->load();
   }
}
```

## Entry Point:

Here you should setup access rules, controllers namespace setup, register routes, and other setting for concrete entry point, and run application.

```php
class Site extends \Core\EntryPoint
{
   public function init()
   {
    Config::set('site.language', 'ru');
    Routes::register();

    $this->setLib('\Accounting\Controller');
    $app = new App($this);
    $app->run();
   }
}
```

## Object
 
Object classes are models. It contains description of data table fields, name, and relations to other entities. Here is config example.

```php
self::$_config->setTable('User');
self::$_config->setFields([
          'name' => [
            'type' => 'varchar',
            'default' => '',
            'null' => false,
],
'password' => [
            'type' => 'varchar',
            'default' => '',
            'null' => false,
]); 
```
 
## Routes
 
In “Routes” you can create routing class for each entry point and redefine default routing rules.
Add custom route example: 

```php
\Core\Router::register(['/add', 'post'], 'Index', 'new', []);
```

It means that POST query to /add url will go to controller: Index, method: methodNew().
 
Default routing rules:
 
/controller/ -- Controller, methodIndex().
/controller/action -- Controller, methodAction().

 

## Framework Philosophy

### Object
Object is a model, which represents some entity

Main methods:
$obj->setValue(‘property’, $value); // or setValues, for multiple values set
$obj->getValue(‘property’); // or getValues, for getting all values

Also in ActiveRecord-style:
$obj->property = $value;
$obj->save();

Framework supports relations between models. 


### Collection
Represents wrapper class for objects array with methods and properties. 

getData() - returns array of full objects, keys are object ids.
getHashMap(‘id’,’name’) - returns hash array, id => name
getValues(‘id’) - returns simple array of ids

### Collection Stream

Uses for complex filtering objects in collections. Example:
```php
$stream = $collection->stream();

$filter1 = function($obj) { /* complex filtering logic */  };
$stream = $stream->filter($filter1);

$filter2 = function($obj) { /* complex filtering logic */  }
$stream = $stream->filter($filter2);

//And then return filtered collection:
$stream->find(); 
```

## Database

### Raw queries

You can still write raw mysql queries using PDO.
```php
$db = \Core\Database\PDO::getInstance();
$result = $this->db->rows("SELECT * FROM `Entry` WHERE user_id = ?", array($user_id));
```

### Small Queries Helper

Also there is small class for trivial queries.

```php
MySQL::insert($table, $params);
MySQL::update($table, $params, $conditions);
MySQL::delete($table, $conditions);
```
Examples:
```php
MySQL::update(‘User’,  array(‘name’ => $new_name), array(‘id’ => 1));
MySQL::delete(‘User’,  array(‘id’ => 1));
```
### QueryBuilder

For step-by-step queries constructing with many different conditions.
Also used internally in \Core\Orm.

composeSelectQuery() method will return raw query string for executing.

$query = new QueryBuilder(‘User’);
$query->setBaseAlias('pc')
->select('id', 'title', 'name')
->join('left', User_Catalog, 'pc', ['catalog', 'another.id'])
->where('somevalue', [124, 125])
->where('max(count)', 20, '<')
->where('title', '%test', 'like')
->where('test', null);
->orderBy('id', 'asc')
->groupBy('param1')
->limit(20);

echo $query->composeSelectQuery();

### Orm

Layer for working with Database, which encapsulate queries and supports relations.

Main methods:
```php
Orm::create($class_name);
Orm::save($object);
Orm::delete($object);

Orm::find($class_name, $filterFields, $filterValues, $params);
Orm::findOne($class_name, $filterFields, $filterValues, $params);
Orm::load($class_name, $id);
Orm::count($class_name, $filterFields, $filterValues);
```
Simple examples:
```php
$user = Orm::create(‘User’);
$user->setValues(array(‘name’ => $name, ‘password’ => $password));
Orm::save($user);

$users = Orm::find(‘User’, array(‘name’, ‘type’), array($name, $type)));
$user = Orm::load(‘User’, 12);
Orm::delete($user);
```

### Mapper

Another class, more flexible.
```php
$mapper = OrmMapper::create(User);
$mapper->setFields(['test', 'name', 'amount']);
->setFilter(['test', 'name', 'amount'], [1,2,3]);
->load();

$users  = $mapper->getCollection();
```


### ActiveRecord

Convenient way to work with objects
Some examples:
```php
$users = User::all()
->addFilter(‘type’, $id)
->load()
->getCollection();

$user = User::find($id);
$user->name = ‘Peter’;
$user->save();
```
