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
  
}
