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
   * @var boolean
   */
  public $PK;
  /**
   * @var boolean
   */
  public $NotNull;
  /**
   * @var boolean
   */
  public $Increment;
  
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
  public function __construct(Table $table,string $name,string $type,array $properties,&$ref)
  {
      $this->table = $table;
      $this->name = $name;
      $this->type = $type;
      foreach($properties as $propery)
      if(!empty($propery[0]) && strtolower($propery[0])=='pk')
        $this->PK = true;
      if(!empty($propery[0]) && strtolower($propery[0])=='not null')
        $this->NotNull = true;
      if(!empty($propery[0]) && strtolower($propery[0])=='increment')
        $this->Increment = true;
      if(!empty($propery[2]) && strtolower($propery[2])=='ref')
        $ref = [$propery[3],$propery[4],$propery[5]];
      

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
