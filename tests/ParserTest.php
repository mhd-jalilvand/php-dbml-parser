<?php
declare(strict_types=1);

require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use DbmlParser\Parser;

final class ParserTest extends TestCase
{
    public function testCreateObjectInstance(): void
    {
      $parser = new parser('tests/test.dbml');
      $this->assertInstanceOf(
          Parser::class,
          $parser
      );
      $this->assertInternalType(
        'array',
          $parser->tables
      );
      
    }
    public function testTableExists(): void
    {
      $parser = new parser('tests/test.dbml');
      $this->assertInstanceOf(
        Parser\Table::class,
          $parser->test1
      );      
     
    }
    public function testTableNotExists(): void
    {
      $parser = new parser('tests/test.dbml');
      
      $this->assertNull(
          $parser->not_exists_table
      );      
    }
}
