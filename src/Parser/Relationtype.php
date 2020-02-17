<?php
namespace DbmlParser\Parser;

/**
 * Class Relationtype
 * @package Parser
 */
class Relationtype
{
  public const ONE2MANY = 1;
  public const MANY2ONE = 2;
  public const ONE2ONE = 3;
  
  public $type;
  public function __construct(string $type){
    switch($type ){
      case '<': $this->type =  self::ONE2MANY;break;
      case '>': $this->type =  self::MANY2ONE;break;
      case '-': $this->type =  self::ONE2ONE;break;
    }
  }
  
  public function __toString(){
    switch($this->type ){
      case self::ONE2MANY: return  '<';break;
      case self::MANY2ONE: return  '>';break;
      case self::ONE2ONE:  return  '-';break;
    }
  }
  
}
