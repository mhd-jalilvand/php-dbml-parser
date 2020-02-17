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
  echo $relation->foreign_table->name.'.'.$relation->foreign_column->name.' : ';
  echo PHP_EOL;
}
