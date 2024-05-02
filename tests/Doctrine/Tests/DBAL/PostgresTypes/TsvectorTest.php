<?php

namespace Doctrine\Tests\DBAL\PostgresTypes;

use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use Doctrine\DBAL\Types\Type;
use PHPUnit\Framework\TestCase;

class TsvectorTest extends TestCase
{
    /**
     * @var \Doctrine\DBAL\PostgresTypes\TsvectorType
     */
    protected $_type;

    /**
     * @var PostgreSqlPlatform
     */
    protected $_platform;

    /**
     * Pre-instantiation setup.
     */
    public static function setUpBeforeClass(): void
    {
        Type::addType('tsvector', 'Doctrine\\DBAL\\PostgresTypes\\TsvectorType');
    }

    /**
     * Pre-execution setup.
     */
    protected function setUp(): void
    {
        $this->_platform = new PostgreSqlPlatform();
        $this->_type = Type::getType('tsvector');
    }

    /**
     * Test conversion of PHP array to database value.
     */
    public function testTsvectorConvertsToDatabaseValue()
    {
        $this->assertIsString($this->_type->convertToDatabaseValue(array('simple', 'extended'), $this->_platform));
    }

    /**
     * Test conversion of database value to PHP array.
     */
    public function testTsvectorConvertsToPHPValue()
    {
        $this->assertIsArray($this->_type->convertToPHPValue('ts:simple ts:extended', $this->_platform));
    }
}
