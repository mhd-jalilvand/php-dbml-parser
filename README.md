# php-dbml-parser
Parse database markup language (DBML)

You can use [Diagram.io](https://dbdiagram.io/) to visually design your database diagram and write down the codes in a 
file and parse it using this script to parse it.

## Installation
```
composer require mhd-jalilvand/php-dbml-parser
```
## Usage
  tests/test.dbml contains a sample database schema as:
```
table posts {
  id int [pk, increment]
  title varchar [not null]
}

table comments {
  id int [pk,increment]
  comment varchar 
  post_id int [not null,ref: > posts.id]
}
table tags{
  id int [pk, increment, not null]
  title varchar [not null]
}

table post_tags{
  id int [pk]
  post_id int
  tag_id int
}




Ref: "tags"."id" < "post_tags"."tag_id"

Ref: "posts"."id" < "post_tags"."post_id"

```
Example code:

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
echo 'Relations:'.PHP_EOL;
foreach($parser->relations as $relation){
  echo $relation->table->name.'.'.$relation->column->name;
  echo ' '.$relation->type.' ';
  echo $relation->foreign_table->name.'.'.$relation->foreign_column->name.PHP_EOL;
}
```
Results:
```json
posts:
        {"name":"id","type":"int","PK":true,"NotNull":null,"Increment":true,"comment":null}
        {"name":"title","type":"varchar","PK":null,"NotNull":true,"Increment":null,"comment":null}
comments:
        {"name":"id","type":"int","PK":true,"NotNull":null,"Increment":true,"comment":null}
        {"name":"comment","type":"varchar","PK":null,"NotNull":null,"Increment":null,"comment":null}
        {"name":"post_id","type":"int","PK":null,"NotNull":null,"Increment":null,"comment":null}
tags:
        {"name":"id","type":"int","PK":true,"NotNull":true,"Increment":null,"comment":null}
        {"name":"title","type":"varchar","PK":null,"NotNull":true,"Increment":null,"comment":null}
post_tags:
        {"name":"id","type":"int","PK":true,"NotNull":null,"Increment":null,"comment":null}
        {"name":"post_id","type":"int","PK":null,"NotNull":null,"Increment":null,"comment":null}
        {"name":"tag_id","type":"int","PK":null,"NotNull":null,"Increment":null,"comment":null}
Relations:
tags.id < post_tags.tag_id
posts.id < post_tags.post_id
comments.post_id > posts.id

```
