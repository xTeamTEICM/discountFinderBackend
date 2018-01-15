<?php
/**
 * Created by PhpStorm.
 * User: xNeo
 * Date: 3/12/2017
 * Time: 4:55 μμ
 */

namespace Tests;

use App\CustomClasses\Distance;

class DistanceTest extends TestCase
{

    // some default coordinates from googlemaps
    // // tei SERRWN        41.074879, 23.553681
    // mamasPizza Serres   41.082279, 23.543239
    //souvlakia mixail serres 41.081964, 23.542144
    //dimotiko gipedo serres 41.084891, 23.546463
    //expected distance  mamasPizza-dimotiko gipedo serres =~ 400 meters
    //expected distance  mamasPizza-souvlakia mixail =~ 97 meters
    //expected distance  mamasPizza-tei serrwn =~ 1250 meters


    public function testCheckDistanceBetweenMammasAndDimotikoGhpedo()
    {
        //expected near 400 meters
        $mamasPizzaCoordinates = new Distance(41.082279, 23.543239);

        $distance = $mamasPizzaCoordinates->calculateDistanceInMeters(41.084891, 23.546463);
        $this->assertTrue($distance <= 400);
        $this->assertTrue($distance >= 380);

    }


    public function testCheckDistanceBetweenMammasAndsouvlakiaMixail()
    {
        //expected near 100 meters
        $mamasPizzaCoordinates = new Distance(41.082279, 23.543239);

        $distance = $mamasPizzaCoordinates->calculateDistanceInMeters(41.081964, 23.542144);
        $this->assertTrue($distance <= 100);
        $this->assertTrue($distance >= 95);

    }

    public function testCheckDistanceBetweenMammasAndTei()
    {
        //expected near 1250 meters
        $mamasPizzaCoordinates = new Distance(41.082279, 23.543239);

        $distance = $mamasPizzaCoordinates->calculateDistanceInMeters(41.074879, 23.553681);
        $this->assertTrue($distance <= 1250);
        $this->assertTrue($distance >= 1190);

    }

    public function testInvalidDistanceBetweenMammasAndTei()
    {
        $mamasPizzaCoordinates = new Distance(41.082279, 23.543239);

        $distance = $mamasPizzaCoordinates->calculateDistanceInMeters(41.074879, 23.553681);
        $this->assertFalse($distance <= 400);


    }


}
