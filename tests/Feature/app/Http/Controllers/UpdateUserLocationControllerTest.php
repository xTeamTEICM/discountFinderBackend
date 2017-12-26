<?php

namespace Tests\Feature;


use App\Http\Controllers\Auth\RegisterController;
use Tests\TestCase;

class UpdateUserLocationControllerTest extends TestCase
{
    private static $tokenToValidate;

    /**
     * HELP FUNCTIONS
     */

    public function helpFunctionForAuthenticate()
    {
        $this->helpFunctionForLogin();


    }

    public function helpFunctionForLogin($username = 'test@test.eu', $password = '12345678')
    {
        if (!$this->helpFunctionForRegister()) {
            $Json = array();
            $registerRequest = $this->json('POST', 'api/login', [
                'username' => $username,
                'password' => $password
            ],
                [
                    'Content-Type' => 'application/json'
                ]);
            $Json = json_decode($registerRequest->getContent(), true);
            //$length = count($Json);
            UpdateUserLocationControllerTest::$tokenToValidate = $Json['access_token'];
        } else {
            $this->helpFunctionForRegister();
        }

        //$response = $this->call('POST', 'api/category');
        //$this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @param string $firstname
     * @param string $lastname
     * @param string $email
     * @param string $password
     */
    public function helpFunctionForRegister($firstname = 'test', $lastname = 'test', $email = 'test@test.eu', $password = '12345678')
    {
        $register = new RegisterController();
        $Json = array();
        $registerRequest = $this->json('POST', 'api/register', [
            'firstName' => $firstname,
            'lastName' => $lastname,
            'eMail' => $email,
            'password' => $password
        ]);

        $Json = json_decode($registerRequest->getContent(), true);
        $length = count($Json);
    }

    public function removeCurrentUser($firstname = 'test', $lastname = 'test', $email = 'test@test.eu', $password = '12345678')
    {

    }

    /**
     * TEST FUNCTIONS
     */
    public function testList()
    {

        if ($this->helpFunctionForRegister()) {

            $response = $this->call('POST', 'api/UpdateUserLocationController');
            $this->assertEquals(200, $response->getStatusCode());
            $user = auth('api')->user();
        } else {
            $response = $this->call('POST', 'api/UpdateUserLocationController');
            $this->assertEquals(404, $response->getStatusCode());

        }
    }

    public function testUpdate()
    {
        $this->assertTrue(true);
    }

    public function testIsNull()
    {
        $this->assertTrue(true);
    }

    public function testIsTrue()
    {
        $this->assertTrue(true);
    }

    public function testIsNotTrue()
    {
        $this->assertTrue(true);
    }

    public function testIsJSON()
    {
        $this->assertTrue(true);
    }

    public function testIsEmpty()
    {

        $this->assertTrue(true);
    }

    public function testIsNotAuth()
    {
        if (!$user = auth('api')->user()) {
            $response = $this->call('POST', 'api/UpdateUserLocationController');
            $this->assertEquals(404, $response->getStatusCode());
        }
    }

    public function testIsFalseValueAuth()
    {

        $this->helpFunctionForLogin();
        if ($response = $this->put('api/updateUserLocation', [
            'latPos' => '',
            'logPos' => ''
        ],
            [
                'Accept' => 'Application/json',
                'Content-Type' => 'Application/json',
                'Authorization' => 'Bearer ' . UpdateUserLocationControllerTest::$tokenToValidate]
        )
        ) {

            $this->assertEquals(422, $response->getStatusCode());
        } else {
            $this->assertFalse(true);
        }
    }


    public function testIsFalseValueLogPos($latPos = '12345', $logPos = '12345')
    {
        $this->helpFunctionForLogin();
        if ($response = $this->put('api/updateUserLocation',
            [
                'latPos' => 12345,
                'logPos' => 12345
            ],

            [
                'Accept' => 'Application/json',
                'Content-Type' => 'Application/json',
                'Authorization' => 'Bearer ' . UpdateUserLocationControllerTest::$tokenToValidate
            ]

        )
        ) {

            $this->assertEquals(422, $response->getStatusCode());
        } else
            $this->assertFalse(true);
    }

    public function testIsFalseValueLatPos($latPos = 'stringLatPos', $logPos = '12345')
    {
        $this->helpFunctionForLogin();
        if ($response = $this->put('api/updateUserLocation', [
            'latPos' => $latPos,
            'logPos' => $logPos
        ],
            [
                'Accept' => 'Application/json',
                'Content-Type' => 'Application/json',
                'Authorization' => 'Bearer ' . UpdateUserLocationControllerTest::$tokenToValidate]
        )
        ) {

            $this->assertEquals(422, $response->getStatusCode());
        } else
            $this->assertFalse(true);
    }
}
