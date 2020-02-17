<?php
namespace DbmlParser\Parser;

use DbmlParser\Parser\Table;
use DbmlParser\Parser\Column;
use DbmlParser\Parser\Relationtype;


/**
 * Class Relation
 * @package Parser
 */
class Relation
{  
  /**
   * primery table
   * @var Table
   */
  public $table;
  
  /**
   * primery column 
   * @var Column
   */
  public $column;
  
  /**
   * foreign table
   * @var Table
   */
  public $foreign_table;
  
  /**
   * foreign column
   * @var array
   */
  public $foreign_column;
  
  /**
   * relation type
   * @var Relationtype
   */
  public $type;
  
  /**
   * column constructor.
   * @param Table $param
   * @param Column $param
   * @param Relationtype $param
   * @param Table $param
   * @param Column $param
   * @throws Exception
   */
  public function __construct(Table $table, Column $column,Relationtype $type, Table $foreign_table, Column $foreign_column)
  {
      $this->table = $table;
      $this->column = $column;
      $this->foreign_table = $foreign_table;
      $this->foreign_column = $foreign_column;
      $this->type = $type;

  }
  
}
