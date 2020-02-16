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
  public $table;
  
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
  public function __construct(Table $table,string $name,string $type,string $properties)
  {
      $this->table = $table;
      $this->name = $name;
      $this->type = $type;

  }
  /**
  * Override method to display column name as string 
  * @return string
  */
  public function __toString():string{
    return $this->name;
  }
  
}
