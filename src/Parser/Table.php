<?php
namespace DbmlParser\Parser\Table;

use Column;
use Relation;


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
   * @param Column[] $columns
   * @throws Exception
   */
  public function __construct(string $name,string $alias,string $table_props,array $columns)
  {
      $this->name = $name;
      $this->alias = $alias;
      $this->table_props = $table_props;
      $this->columns = $columns;
  }
  
}
