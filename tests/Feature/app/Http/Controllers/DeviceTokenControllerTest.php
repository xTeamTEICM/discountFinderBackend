<?php


namespace Tests\Feature;

use Tests\TestCase;

class deviceTokenControllerTest extends TestCase
{

    protected static $AuthValues;

    // getting access_token
    public function testGetAuthValuesFromStaticUser()
    {
        $response = $this->json('POST', 'api/login', [
            'username' => 'TestUser@JNKSoftware.eu',
            'password' => '1234567'
        ]);

        deviceTokenControllerTest::$AuthValues = json_decode($response->getContent(), true);
        $response->assertStatus(200);
    }


    public function testEmptyFieldDeviceToken()
    {
        $token = deviceTokenControllerTest::$AuthValues['access_token'];
        $response = $this->withHeader(
            'Authorization',
            'Bearer ' . $token
        )->json(
            'POST', 'api/user/deviceToken', [

        ]);

        $response->assertJson([
            'errors' => ['deviceToken' => ['The device token field is required.']]]);

    }

    public function testSuccessStatus()
    {
        $token = deviceTokenControllerTest::$AuthValues['access_token'];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('POST', 'api/user/deviceToken', [
            'deviceToken' => 'testing'

        ]);

        $response->assertStatus(200);
    }

    public function testDatabaseData()
    {
        $this->assertDatabaseHas('users', ['deviceToken' => 'testing']);

    }

    public function testUpdateSuccessStatus()
    {
        $token = deviceTokenControllerTest::$AuthValues['access_token'];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('POST', 'api/user/deviceToken', [
            'deviceToken' => 'Test'

        ]);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('users', ['deviceToken' => 'testing']);
        $this->assertDatabaseHas('users', ['deviceToken' => 'Test']);
    }

}
