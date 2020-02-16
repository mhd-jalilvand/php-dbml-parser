<?php
require 'vendor/autoload.php';
use DbmlParser\Parser;
$parser = new Parser('tests/test.dbml');
foreach($parser->tables as $table){
  echo $table->name.':['.implode(',',$table->columns).']'.PHP_EOL;
}
