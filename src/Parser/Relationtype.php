<?php
namespace DbmlParser\Parser;

/**
 * Class Relationtype
 * @package Parser
 */
class Relationtype
{
  /**
   * relation type
   * @var int ONE2MANY 
   * @var int MANY2ONE 
   * @var int ONE2ONE 
   */
  public const ONE2MANY = 1;
  public const MANY2ONE = 2;
  public const ONE2ONE = 3;
  
  protected $type;
  
  /**
   * column constructor.
   * @param string $type
   * @throws Exception
   */
  public function __construct(string $type) 
  {
    switch($type ){
      case '<': $this->type =  self::ONE2MANY;break;
      case '>': $this->type =  self::MANY2ONE;break;
      case '-': $this->type =  self::ONE2ONE;break;
    }
  }
  
  /**
   * __toString magic function
   * @return string $type <->
   * @throws Exception
   */  
  public function __toString():string
  {
    switch($this->type ){
      case self::ONE2MANY: return  '<';break;
      case self::MANY2ONE: return  '>';break;
      case self::ONE2ONE:  return  '-';break;
    }
  }
  
}
