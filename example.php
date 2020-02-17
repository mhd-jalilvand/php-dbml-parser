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
