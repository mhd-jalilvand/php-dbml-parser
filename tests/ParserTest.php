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
    }
    
    public function testTablesIsArray(): void
    {
      $parser = new parser('tests/test.dbml');
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
          $parser->posts
      );      
     
    }
    public function testTableNotExists(): void
    {
      $parser = new parser('tests/test.dbml');
      
      $this->assertNull(
          $parser->not_exists_table
      );      
    }
    
    public function testTableColumns(): void
    {
      $parser = new parser('tests/test.dbml');
      $this->assertArraySubset(
        ['id','title'],
          $parser->posts->columns
      );  
    }
    
    public function testTableRelations(): void
    {
      $parser = new parser('tests/test.dbml');
      $this->assertCount(
        3,
          $parser->relations
      );  
    }
}
