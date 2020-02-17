# php-dbml-parser
Parse database markup language (DBML)

You can use [Diagram.io](https://dbdiagram.io/) to visually design your database diagram and write down the codes in a 
file and parse it using this script to parse it.

## Installation
```
composer require mhd-jalilvand/php-dbml-parser
```
## Usage
```php
<?php
require 'vendor/autoload.php';
use DbmlParser\Parser;
$parser = new Parser('tests/test.dbml');
foreach($parser->tables as $table){
  echo $table->name.':'.PHP_EOL;
  foreach($table->columns as $column){
    echo "\t".json_encode($column).PHP_EOL;
  }
}
```
Results:
```
posts:
        {"name":"id","type":"int","properties":["pk","increment"],"comment":null}
        {"name":"title","type":"varchar","properties":["not null"],"comment":null}
comments:
        {"name":"id","type":"int","properties":["pk","increment"],"comment":null}
        {"name":"comment","type":"varchar","properties":[],"comment":null}
        {"name":"post_id","type":"int","properties":["ref: > posts.id"],"comment":null}

```
