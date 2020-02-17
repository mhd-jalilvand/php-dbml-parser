<?php
namespace DbmlParser;

use DbmlParser\Parser\Table;
use DbmlParser\Parser\Column;
use DbmlParser\Parser\Relation;
use DbmlParser\Parser\Relationtype;

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
     * @var Relation[]
     */
    protected $_relations = [];

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
      $name_striped = str_replace(['"',"'"],'',$name);
      if($name=='tables'){
        return $this->_tables;
      }
      
      else if($name=='relations'){
        return $this->_relations;
      }
      //access table by Table's name
      else foreach($this->tables as $table){
        if($table->name==$name || $table->name==$name_striped)
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
      $this->parse_dbml(  $dbml );

        return $this;
    }
    
    /**
     * @param string $content
     * @return array
     * @throws Exception
     */
    private function parse_dbml(string $raw_data)
    {
      $relation_queues = [];
      $w = '"\w+"|\w+';
      $reg_table  = '/table\s+('.$w.')\s*(\s*as\s+[\w]+|\s*as\s+"[\w]+"|)(\s\[.*]|)\s*{(\s|\n|[^}]*)}/im';
      $reg_column = '/('.$w.')+\s+('.$w.')(\s+\[[^]]*]|)[ ]*\n/im';
      $reg_column_properties = '/pk|increment|not null|((ref)\s*:\s*([<>-])\s*('.$w.')\.('.$w.'))/im';
      $reg_relations = '/ref:\s*('.$w.')\.('.$w.')\s+([-<>])\s+('.$w.')\.('.$w.')/im';
      
      
      preg_match_all($reg_table, $raw_data, $tables, PREG_SET_ORDER);
      preg_match_all($reg_relations, $raw_data, $relations, PREG_SET_ORDER);
      
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
            
            preg_match_all($reg_column_properties, $column_item[3], $column_properties,PREG_SET_ORDER);
            /*
            $column_properties must be an array, each one as:
            array[
              0:array of properties 
              if property is ref then it must be like:
              array[
                0:ref
                1:foreign_table
                2:foreign_column
              ]
            ]
            */
            
            $ref = null;
            $column = new Column(
              $table,
              $column_item[1],
              $column_item[2],
              $column_properties,
              $ref
            );
            
            $table->columns[] = $column;
            
            //if there is foreign key refrence in column 
            //add it to the queue to be added in the relations
            if(!empty($ref))
              $relation_queues[] = [$table,$column,$ref];
          }
          $this->_tables[] = $table;
      }
      
      /*
      $relation must be an array, each one as:
        array[
          0: raw data 
          1: primery table 
          2: primery column
          3: relation type
          4: foreign table
          5: foreign column
      ]
      */
      foreach($relations as  $relation)  {
        $table = $relation[1];
        $column = $relation[2];
        $type = $relation[3];
        $foreign_table = $relation[4];
        $foreign_column = $relation[5];
        
        
        $table = $this->$table ;
        $column = $table->$column ;
        $foreign_table = $this->$foreign_table ;
        $foreign_column = $foreign_table->$foreign_column ;
        $type = new Relationtype($type );
                  
        $this->_relations[] = new Relation(
            $table,
            $column,
            $type,
            $foreign_table,
            $foreign_column
          );
      }
      
      foreach($relation_queues as $relation_queue){
        $foreign_table = $relation_queue[2][1];
        $foreign_table = $this->$foreign_table;
        
        $foreign_column = $relation_queue[2][2];
        $foreign_column =  $foreign_table->$foreign_column;
        
        $this->_relations[] = new Relation(
            $relation_queue[0],
            $relation_queue[1],
            new Relationtype($relation_queue[2][0]),
          $foreign_table,
            $foreign_column
          );
      }
      
      return $this;
    }  

    
}
