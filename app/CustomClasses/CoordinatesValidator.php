<?php
/**
 * Created by PhpStorm.
 * User: iordk
 * Date: 29/12/2017
 * Time: 2:00 μμ
 */

namespace App\CustomClasses;


class CoordinatesValidator
{
    public static function isValid($lat, $long)
    {
        return ($lat >= -90 && $lat <= 90) && ($long >= -180 && $long <= 180);
    }
}