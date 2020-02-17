<?php
namespace DbmlParser\Parser;

use DbmlParser\Parser\Column;
use DbmlParser\Parser\Relation;


/**
 * Class Table
 * @package Parser
 */
class Table
{
  /**
   * @var string
   */
  public $name;
  
  /**
   * @var string
   */
  public $alias;
  
  /**
   * @var Column[]
   */
  public $columns = [];
  
  /**
   * @var string
   */
  public $comment;
  
  /**
   * Table constructor.
   * @param string $name
   * @param string $alias
   * @param string $table_props
   * @throws Exception
   */
  public function __construct(string $name,?string $alias = null,?string $table_props = null)
  {
      $this->name = $name;
      $this->alias = $alias;
      $this->table_props = $table_props;
  }
  
  /**
   * Table __get magic function
   * @param string $name
   * @throws Exception
   */    
  public function __get($name){
    $name_striped = str_replace(['"',"'"],'',$name);
    //access column by Column's name
    foreach($this->columns as $column){
      if($column->name==$name || $column->name==$name_striped)
        return $column;
    }
    return null;
  }  
}
