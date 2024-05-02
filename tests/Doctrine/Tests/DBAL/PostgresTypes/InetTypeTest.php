<?php

namespace Doctrine\Tests\DBAL\PostgresTypes;

use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use Doctrine\DBAL\Types\Type;
use PHPUnit\Framework\TestCase;

class InetTypeTest extends TestCase
{
    /**
     * @var \Doctrine\DBAL\PostgresTypes\InetType
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
        Type::addType('inet', 'Doctrine\\DBAL\\PostgresTypes\\InetType');
    }

    /**
     * Pre-execution setup.
     */
    protected function setUp(): void
    {
        $this->_platform = new PostgreSqlPlatform();
        $this->_type = Type::getType('inet');
    }

    /**
     * Test conversion of PHP array to database value.
     *
     * @dataProvider databaseConvertProvider
     */
    public function testInetConvertsToDatabaseValue($serialized, $phpValueToConvert)
    {
        $converted = $this->_type->convertToDatabaseValue($phpValueToConvert, $this->_platform);
        $this->assertIsString($converted);
        $this->assertEquals($serialized, $converted);
    }

    /**
     * Test conversion of database value to PHP array.
     *
     * @dataProvider databaseConvertProvider
     */
    public function testInetConvertsToPHPValue($serialized, $databaseValueToConvert)
    {
        $converted = $this->_type->convertToPHPValue($serialized, $this->_platform);
        $this->assertIsString($converted);
        $this->assertEquals($databaseValueToConvert, $converted);
    }

    /**
     * @expectedException \InvalidArgumentException
     *
     * @dataProvider exceptionProvider
     */
    public function testInetThrowExceptionOnConversion($value)
    {
        $this->_type->convertToDatabaseValue($value, $this->_platform);
    }

    /**
     * Provider for conversion test values.
     *
     * @return array
     */
    public static function databaseConvertProvider()
    {
        return array(
            array('10.0.0.1', '10.0.0.1'),
            array('10.0.0.1/4', '10.0.0.1/4'),
        );
    }

    /**
     * @return array
     */
    public static function exceptionProvider()
    {
        return array(
            array(''),
            array('someothervalue'),
            array(123),
            array('123345'),
        );
    }
}
