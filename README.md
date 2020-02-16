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
  echo $table->name.':['.implode(',',$table->columns).']'.PHP_EOL;
}
```
Results:
```
posts:[id,title]
comments:[id,comment,post_id]
```
