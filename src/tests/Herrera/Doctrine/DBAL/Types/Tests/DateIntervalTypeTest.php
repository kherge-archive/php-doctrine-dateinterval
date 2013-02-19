<?php

namespace Herrera\Doctrine\DBAL\Types\Tests;

use DateInterval;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Doctrine\Tests\DbalTestCase;
use Doctrine\Tests\DBAL\Mocks\MockPlatform;
use Herrera\Doctrine\DBAL\Types\DateIntervalType;

class DateIntervalTypeTest extends DbalTestCase
{
    /**
     * @var AbstractPlatform
     */
    protected $platform;

    /**
     * @var DateIntervalType
     */
    protected $type;

    public function testConvertToDatabaseValue()
    {
        $interval = new DateInterval('PT30S');

        $this->assertEquals(
            '30',
            $this->type->convertToDatabaseValue($interval, $this->platform)
        );
        $this->assertNull(
            $this->type->convertToDatabaseValue(null, $this->platform)
        );
    }

    public function testConvertToPHPValueInvalid()
    {
        $this->setExpectedException(
            'Doctrine\\DBAL\\Types\\ConversionException'
        );

        $this->type->convertToPHPValue('abcd', $this->platform);
    }

    public function testConvertToPHPValue()
    {
        $interval = $this->type->convertToPHPValue('30', $this->platform);

        $this->assertEquals(30, $interval->s);
        $this->assertNull(
            $this->type->convertToPHPValue(null, $this->platform)
        );
    }

    protected function setUp()
    {
        $this->platform = new MockPlatform();
        $this->type = Type::getType('dateinterval');
    }
}