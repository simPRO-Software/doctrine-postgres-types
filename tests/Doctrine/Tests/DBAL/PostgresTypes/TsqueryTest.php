<?php

namespace Doctrine\Tests\DBAL\PostgresTypes;

use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use Doctrine\DBAL\Types\Type;
use PHPUnit\Framework\TestCase;

class TsqueryTest extends TestCase
{
    /**
     * @var \Doctrine\DBAL\PostgresTypes\TsqueryType
     */
    protected $type;

    /**
     * @var PostgreSqlPlatform
     */
    protected $platform;

    /**
     * Pre-instantiation setup.
     */
    public static function setUpBeforeClass(): void
    {
        Type::addType('tsquery', 'Doctrine\\DBAL\\PostgresTypes\\TsqueryType');
    }

    /**
     * Pre-execution setup.
     */
    protected function setUp(): void
    {
        $this->platform = new PostgreSqlPlatform();
        $this->type = Type::getType('tsquery');
    }

    /**
     * Test conversion to database value.
     */
    public function testConvertToDatabaseValueSQL()
    {
        $this->assertEquals('plainto_tsquery(test)', $this->type->convertToDatabaseValueSQL('test', $this->platform));
    }
}
