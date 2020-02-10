<?php
namespace Parser\Table;

use Parser\Table;
use Parser\Relation;


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
  public comment;
  
  /**
   * Table constructor.
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
  
}
