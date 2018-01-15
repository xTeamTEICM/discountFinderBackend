<?php

namespace App\CustomClasses;


class Distance
{

    protected $userLatPos;
    protected $userLogPos;

    /**
     * Distance constructor.
     * @param $userLatPos
     * @param $userLogPos
     */
    public function __construct($userLatPos, $userLogPos)
    {
        $this->userLatPos = $userLatPos;
        $this->userLogPos = $userLogPos;
    }


    public function calculateDistanceInMeters($shopLatPosition, $shopLogPosition)
    {
        $userLatPos = deg2rad($this->userLatPos);
        $userLogPos = deg2rad($this->userLogPos);
        $shopLogPosition = deg2rad($shopLogPosition);
        $shopLatPosition = deg2rad($shopLatPosition);


        $radiusOfEarth = 6371000;// Earth's radius in meters.
        $diffLatitude = abs($userLatPos - $shopLatPosition);
        $diffLongitude = abs($userLogPos - $shopLogPosition);


        $a = sin($diffLatitude / 2) * sin($diffLatitude / 2) +
            cos($userLatPos) * cos($shopLatPosition) *
            sin($diffLongitude / 2) * sin($diffLongitude / 2);
        $c = 2 * asin(sqrt($a));
        $distance = $radiusOfEarth * $c;

        return (int)$distance;

    }


}