<?php


namespace Tests\Feature;

use Tests\TestCase;

class findDiscountsControllerTest extends TestCase
{

    protected static $AuthValues;


    // getting access_token
    public function testGetAuthValuesFromStaticUser()
    {

        $response = $this->json('POST', 'api/login', [
            'username' => 'user@JNKSoftware.eu',
            'password' => 'myPassword'
        ]);

        findDiscountsControllerTest::$AuthValues=json_decode($response->getContent(),true);
        $response->assertStatus(200);


    }
//--------------------------------------------- TESTING  /findDiscounts---------------------------------------------------------------
    // i am using coordinates from googlemaps
    // 41.088591, 23.551272

    public function testUnauthorizedFind()
    {
        $token = self::$AuthValues['access_token'];
        $response = $this->json('GET', 'api/discount/find/asdasdsa',
            [], [

            ]);

        $response->assertStatus(401);
    }

    public function testInvalidMetersFind()
    {
        $token = self::$AuthValues['access_token'];
        $response = $this->json('GET', 'api/discount/find/asdasdsa',
            [], [
                'Authorization' => 'Bearer ' . $token
            ]);

        $response->assertStatus(422);
    }

    public function testSuccessFind()
    {
        $token = self::$AuthValues['access_token'];
        $response = $this->json('GET', 'api/discount/find/1000',
            [], [
                'Authorization' => 'Bearer ' . $token
            ]);

        $response->assertStatus(200);
    }

    public function testUnauthorizedTop()
    {
        $token = self::$AuthValues['access_token'];
        $response = $this->json('GET', 'api/discount/top/asdasdsa',
            [], [

            ]);

        $response->assertStatus(401);
    }

    public function testInvalidMetersTop()
    {
        $token = self::$AuthValues['access_token'];
        $response = $this->json('GET', 'api/discount/top/asdasdsa',
            [], [
                'Authorization' => 'Bearer ' . $token
            ]);

        $response->assertStatus(422);
    }

    public function testSuccessTop()
    {
        $token = self::$AuthValues['access_token'];
        $response = $this->json('GET', 'api/discount/top/1000',
            [], [
                'Authorization' => 'Bearer ' . $token
            ]);

        $response->assertStatus(200);
    }


}
