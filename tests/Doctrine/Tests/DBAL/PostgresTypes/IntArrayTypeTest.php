<?php

/**
 * This file is part of Opensoft Doctrine Postgres Types.
 *
 * Copyright (c) 2013 Opensoft (http://opensoftdev.com)
 */
namespace Doctrine\Tests\DBAL\PostgresTypes;

use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use Doctrine\DBAL\Types\Type;
use PHPUnit\Framework\TestCase;

/**
 * Class IntArrayTypeTest.
 *
 * Unit tests for the IntArray type
 */
class IntArrayTypeTest extends TestCase
{
    /**
     * @var \Doctrine\DBAL\PostgresTypes\IntArrayType
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
        Type::addType('int_array', 'Doctrine\\DBAL\\PostgresTypes\\IntArrayType');
    }

    /**
     * Pre-execution setup.
     */
    protected function setUp(): void
    {
        $this->_platform = new PostgreSqlPlatform();
        $this->_type = Type::getType('int_array');
    }

    /**
     * Test conversion of PHP array to database value.
     *
     * @dataProvider databaseConvertProvider
     */
    public function testIntArrayConvertsToDatabaseValue($serialized, $array)
    {
        $converted = $this->_type->convertToDatabaseValue($array, $this->_platform);
        $this->assertIsString($converted);
        $this->assertEquals($serialized, $converted);
    }

    /**
     * Test conversion of database value to PHP array.
     *
     * @dataProvider databaseConvertProvider
     */
    public function testIntArrayConvertsToPHPValue($serialized, $array)
    {
        $converted = $this->_type->convertToPHPValue($serialized, $this->_platform);
        $this->assertIsArray($converted);
        $this->assertEquals($array, $converted);

        if (sizeof($converted) > 0) {
            $this->assertIsInt(reset($converted));
        }
    }

    /**
     * Provider for conversion test values.
     *
     * @return array
     */
    public static function databaseConvertProvider()
    {
        return array(
            array('{1,2,3}', array(1,2,3)),
            array('{}', array()),
        );
    }
}
