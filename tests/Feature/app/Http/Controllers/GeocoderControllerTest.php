<?php

namespace Tests\Feature;

use App\Http\Controllers\GeocoderController;
use Tests\TestCase;

class GeocoderControllerTest extends TestCase
{
    public function testTEICMCity()
    {
        $geocoder = new GeocoderController(41.074809, 23.554837, 'el');
        $this->assertEquals('Σέρρες', $geocoder->getCity());
    }

    public function testMammasPizzaCity()
    {
        $geocoder = new GeocoderController(41.082191, 23.543210, 'el');
        $this->assertEquals('Σέρρες', $geocoder->getCity());
    }

    public function testEptamiloiCity()
    {
        $geocoder = new GeocoderController(41.100149, 23.592238, 'el');
        $this->assertEquals('Σέρρες', $geocoder->getCity());
    }

    public function testAgiosIwannisCity()
    {
        $geocoder = new GeocoderController(41.098572, 23.577846, 'el');
        $this->assertEquals('Σέρρες', $geocoder->getCity());
    }

    public function testBenizelouTest()
    {
        $geocoder = new GeocoderController(41.086858, 23.536650, 'el');
        $this->assertEquals('Σέρρες', $geocoder->getCity());
    }

    public function testLefkwnasTest()
    {
        $geocoder = new GeocoderController(41.097248, 23.490835, 'el');
        $this->assertEquals('Σέρρες', $geocoder->getCity());
    }

    public function testMitrousiTest()
    {
        $geocoder = new GeocoderController(41.077119, 23.455962, 'el');
        $this->assertEquals('Σέρρες', $geocoder->getCity());
    }

    public function testKamilaTest()
    {
        $geocoder = new GeocoderController(41.063142, 23.419913, 'el');
        $this->assertEquals('Σέρρες', $geocoder->getCity());
    }

    public function testToskaTest()
    {
        $geocoder = new GeocoderController(40.919377, 24.377907, 'el');
        $this->assertEquals('Καβάλα', $geocoder->getCity());
    }

    public function testStaurosTest()
    {
        $geocoder = new GeocoderController(40.946982, 24.369537, 'el');
        $this->assertEquals('Καβάλα', $geocoder->getCity());
    }

    public function test0_0City()
    {
        new GeocoderController(0, 0, 'el');
        self::assertTrue(true);
    }
}
