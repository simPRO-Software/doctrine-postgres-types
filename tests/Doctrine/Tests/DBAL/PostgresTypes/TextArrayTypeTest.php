<?php

namespace Doctrine\Tests\DBAL\PostgresTypes;

use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use Doctrine\DBAL\Types\Type;
use PHPUnit\Framework\TestCase;

class TextArrayTypeTest extends TestCase
{
    /**
     * @var \Doctrine\DBAL\PostgresTypes\TextArrayType
     */
    protected $_type;

    /**
     * @var PostgreSqlPlatform
     */
    protected $_platform;

    public static function setUpBeforeClass(): void
    {
        Type::addType('text_array', 'Doctrine\\DBAL\\PostgresTypes\\TextArrayType');
    }

    protected function setUp(): void
    {
        $this->_platform = new PostgreSqlPlatform();
        $this->_type = Type::getType('text_array');
    }

    /**
     * @dataProvider provideValidValues
     */
    public function testTextArrayConvertsToDatabaseValue($serialized, $array)
    {
        $this->assertSame($serialized, $this->_type->convertToDatabaseValue($array, $this->_platform));
    }

    /**
     * @dataProvider provideToPHPValidValues
     */
    public function testTextArrayConvertsToPHPValue($serialized, $array)
    {
        $this->assertSame($array, $this->_type->convertToPHPValue($serialized, $this->_platform));
    }

    public static function provideValidValues()
    {
        return array(
            array('{}', array()),
            array('{""}', array('')),
            array('{NULL}', array(null)),
            array('{"1,NULL"}', array('1,NULL')),
            array('{"NULL,2"}', array('NULL,2')),
            array('{"1",NULL}', array('1', null)),
            array('{"NULL"}', array('NULL')),
            array('{"1,NULL"}', array('1,NULL')),
            array('{"1","2"}', array('1', '2')),
            array('{"1\"2"}', array('1"2')),
            array('{"\"2"}', array('"2')),
            array('{"\"\""}', array('""')),
            array('{"1","2"}', array('1', '2')),
            array('{"1,2","3,4"}', array('1,2', '3,4')),
        );
    }

    public static function provideToPHPValidValues()
    {
        return self::provideValidValues() + array(
            array('{NULL,2}', array(null, '2')),
            array('{NOTNULL}', array('NOTNULL')),
            array('{NOTNULL,2}', array('NOTNULL', '2')),
            array('{NULL2}', array('NULL2')),
            array('{1,2}', array('1', '2')),
        );
    }
}
