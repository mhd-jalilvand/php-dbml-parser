<?php
namespace DbmlParser;

use DbmlParser\Parser\Table;
use DbmlParser\Parser\Column;
use DbmlParser\Parser\Relation;

/**
 * Class Parser
 * @package Parser
 */
class Parser
{
    /**
     * @var string
     */
    protected $filename;

    /**
     * @var Table[]
     */
    protected $_tables = [];

    /**
     * Parser constructor.
     * @param string $filename
     * @throws Exception
     */
    public function __construct(string $filename)
    {
        $this->filename = $filename;
        $this->parse();
    }
    
    /**
     * Parser __set magic function
     * @param string $name
     * @param ? $value
     * @throws Exception
     */    
    public function __set($name,$value){
      //dont allow changing protected "$tables"
      if($name=='tables' || $name=='_tables'){
        throw new Exception('You can not set protected properties!');
      }
      else $this->$name=$value;
    }
    
    /**
     * Parser __get magic function
     * @param string $name
     * @throws Exception
     */    
    public function __get($name){
      if($name=='tables'){
        return $this->_tables;
      }
      //access table by Table's name
      else foreach($this->tables as $table){
        if($table->name==$name)
          return $table;
      }
      return null;
    }

    /**
     * @return Parser
     * @throws Exception
     */
    protected function Parse(): Parser
    {
        $dbml = file_get_contents($this->filename);
        
        //tables: array key:table name and value Table object
        $this->_tables = $this->parse_dbml(  $dbml );

        return $this;
    }
    
    /**
     * @param string $content
     * @return array
     * @throws Exception
     */
    private function parse_dbml(string $raw_data): Array
    {
      $result = [];

      $reg_table  = '/table\s+("[\w]+"|[\w]+)\s*(\s*as\s+[\w]+|\s*as\s+"[\w]+"|)(\s\[.*]|)\s*{(\s|\n|[^}]*)}/im';
      $reg_column = '/("[\w]+"|[\w]+)+\s+("[\w]+"|[\w]+)(\s+\[[^]]*]|)[ ]*\n/im';
      $reg_column_properties = '/pk|increment|not null|ref:\s*[-><]\s+\w+\.\w+/im';
      preg_match_all($reg_table, $raw_data, $tables, PREG_SET_ORDER);
      /*
      $tables must be an array, each one as:
        array[
        0:table raw data
        1:table name
        2:empty|as alias
        3:empty|[table properties]
        4:columns raw data
      ]
      */
      foreach ($tables as $item) {
        $alias = $table_props = $columns = null;
          $name = trim($item[1]);
          preg_match_all($reg_column, $item[4], $columns,PREG_SET_ORDER);
          /*
          $columns must be an array, each one as:
            array[
              0: column raw data 
              1: column name
              2: columnt type
              3: column properties
          ]
          */
          $table = new Table($name,$alias,$table_props);
          foreach($columns as $column_item){
            $column_properties = [];
            preg_match_all($reg_column_properties, $column_item[3], $column_properties);
            $table->columns[] = new Column(
              $table,
              $column_item[1],
              $column_item[2],
              (!empty($column_properties[0]))?$column_properties[0]:[]
            );
          }
          $result[] = $table;
      }
      
      return $result;
    }  

    
}
