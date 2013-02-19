<?php

namespace Herrera\Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\BigIntType;
use Doctrine\DBAL\Types\ConversionException;
use Herrera\DateInterval\DateInterval;

/**
 * Stores and retrieves DateInterval instances.
 *
 * @author Kevin Herrera <kherrera@ebscohost.com>
 */
class DateIntervalType extends BigIntType
{
    /**
     * The DateInterval type name.
     *
     * @var string
     */
    const DATEINTERVAL = 'dateinterval';

    /**
     * @override
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (null === $value) ? null : DateInterval::toSeconds($value);
    }

    /**
     * @override
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null !== $value) {
            if (false == preg_match('/^\d+$/', $value)) {
                throw ConversionException::conversionFailedFormat(
                    $value,
                    $this->getName(),
                    '^\\d+$'
                );
            }

            $value = DateInterval::fromSeconds($value);
        }

        return $value;
    }

    /**
     * @override
     */
    public function getName()
    {
        return self::DATEINTERVAL;
    }
}