<?php

namespace Doctrine\Tests\DBAL\PostgresTypes;

use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use Doctrine\DBAL\Types\Type;
use PHPUnit\Framework\TestCase;

/**
 * Class XmlTest.
 *
 * Unit tests for the XML type
 */
class XmlTest extends TestCase
{
    /**
     * @var \Doctrine\DBAL\PostgresTypes\XmlType
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
        Type::addType('xml', 'Doctrine\\DBAL\\PostgresTypes\\XmlType');
    }

    /**
     * Pre-execution setup.
     */
    protected function setUp(): void
    {
        $this->_platform = new PostgreSqlPlatform();
        $this->_type = Type::getType('xml');
    }

    /**
     * Test conversion of SimpleXMLElement to database value.
     */
    public function testXmlConvertsToDatabaseValue()
    {
        $this->assertIsString($this->_type->convertToDatabaseValue(new \SimpleXMLElement('<book></book>'), $this->_platform));
    }

    /**
     * Test conversion of database value to SimpleXMLElement.
     */
    public function testXmlConvertsToPHPValue()
    {
        $this->assertInstanceOf('\SimpleXMLElement', $this->_type->convertToPHPValue('<book></book>', $this->_platform));
    }
}
