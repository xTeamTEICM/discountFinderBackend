<?php

namespace Tests\Feature;

use App\CustomClasses\CoordinatesValidator;
use Tests\TestCase;

class CoordinatesValidatorTest extends TestCase
{
    // General Tests
    public function testCoordinatesValid()
    {
        self::assertTrue(CoordinatesValidator::isValid(41.074601, 23.553907));
    }

    public function testCoordinatesInvalid()
    {
        self::assertFalse(CoordinatesValidator::isValid(123, 456));
    }

    // Valid Tests
    public function testCoordinatesValidLatLimitUp()
    {
        self::assertTrue(CoordinatesValidator::isValid(80, 23.553907));
    }

    public function testCoordinatesValidLatLimitDown()
    {
        self::assertTrue(CoordinatesValidator::isValid(-80, 23.553907));
    }

    public function testCoordinatesValidLogLimitUp()
    {
        self::assertTrue(CoordinatesValidator::isValid(80, 180));
    }

    public function testCoordinatesValidLogLimitDown()
    {
        self::assertTrue(CoordinatesValidator::isValid(-80, -180));
    }

    // Invalid Tests
    public function testCoordinatesInvalidLatLimitUp()
    {
        self::assertFalse(CoordinatesValidator::isValid(90.0001, 23.553907));
    }

    public function testCoordinatesInvalidLatLimitDown()
    {
        self::assertFalse(CoordinatesValidator::isValid(-90.0001, 23.553907));
    }

    public function testCoordinatesInvalidLogLimitUp()
    {
        self::assertFalse(CoordinatesValidator::isValid(41.074601, 180.0001));
    }

    public function testCoordinatesInvalidLogLimitDown()
    {
        self::assertFalse(CoordinatesValidator::isValid(41.074601, -180.0001));
    }

    // Invalid Tests Both
    public function testCoordinatesInvalidLimitUp()
    {
        self::assertFalse(CoordinatesValidator::isValid(90.0001, 180.0001));
    }

    public function testCoordinatesInvalidLimitDown()
    {
        self::assertFalse(CoordinatesValidator::isValid(-90.0001, -180.0001));
    }

}
