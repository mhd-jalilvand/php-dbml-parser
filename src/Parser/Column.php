<?php
namespace DbmlParser\Parser;

use DbmlParser\Parser\Table;
use DbmlParser\Parser\Relation;


/**
 * Class Column
 * @package Parser
 */
class Column
{
  /**
   * @var string
   */
  public $name;
  
  /**
   * @var Table
   */
  protected $table;
  
  /**
   * @var string
   */
  public $type;
  
  /**
   * @var array
   */
  public $properties = [];
  
  /**
   * @var string
   */
  public $comment;
  
  /**
   * column constructor.
   * @param Table $table
   * @param string $name
   * @param string $type
   * @param string $properties
   * @throws Exception
   */
  public function __construct(Table $table,string $name,string $type,array $properties)
  {
      $this->table = $table;
      $this->name = $name;
      $this->type = $type;
      $this->properties = $properties;

  }
  /**
  * Override method to display column name as string 
  * @return string
  */
  public function __toString():string{
    return $this->name;
  }
  
  /**
  * Override method to access readonly properties 
  * @return mixed
  */
  public function __get(string $name){
    if($name=='table')
      return $this->table;
  }
  
}
