<?php

namespace Tests\Feature;


use Tests\AuthForTests;
use Tests\TestCase;

class ShopControllerTest extends TestCase
{
    protected static $id;

    public function testPostInvalidLatLog()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $response = $this->json('POST', 'api/shop', [
            'brandName' => 'TestingShop',
            'logPos' => '123',
            'latPos' => '456'
        ], [
            'Authorization' => $tokenKey
        ]);

        $response->assertJsonStructure(['message']);
        $response->assertStatus(422);
    }

    public function testPostNotExisted()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $response = $this->json('POST', 'api/shop', [
            'brandName' => 'TestingShop',
            'logPos' => '12.34',
            'latPos' => '23.45'
        ], [
            'Authorization' => $tokenKey
        ]);

        ShopControllerTest::$id = $response->decodeResponseJson()['id'];

        $response->assertJsonStructure(['ownerId', 'brandName', 'logPos', 'latPos']);
        $response->assertStatus(200);
    }

    public function testPostExisted()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $response = $this->json('POST', 'api/shop', [
            'brandName' => 'TestingShop',
            'logPos' => '12.34',
            'latPos' => '23.45'
        ], [
            'Authorization' => $tokenKey
        ]);

        $response->assertStatus(422);
    }

    public function testList()
    {
        $response = $this->json('GET', 'api/shop', [], []);
        $response->assertJsonStructure([['id', 'ownerId', 'brandName', 'latPos', 'logPos']]);
        $response->assertStatus(200);
    }

    public function testListDiscountsExist()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $response = $this->json('GET', 'api/user/shop/' . ShopControllerTest::$id . '/discounts', [], [
            'Authorization' => $tokenKey
        ]);

        $response->assertStatus(200);
    }

    public function testListDiscountsNotExist()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $response = $this->json('GET', 'api/user/shop/' . '999999' . '/discounts', [], [
            'Authorization' => $tokenKey
        ]);

        $response->assertStatus(404);
    }

    public function testGetExisted()
    {
        $response = $this->json('GET', 'api/shop/' . ShopControllerTest::$id, [], []);
        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'ownerId', 'brandName', 'latPos', 'logPos']);
    }

    public function testGetNotExisted()
    {
        $response = $this->json('GET', 'api/shop/999999', [], []);
        $response->assertStatus(404);
    }

    public function testUserList()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $response = $this->json('GET', 'api/user/shop',
            [], [
                'Authorization' => $tokenKey
            ]);

        $response->assertJsonStructure([['id', 'ownerId', 'brandName', 'latPos', 'logPos']]);
    }

    public function testUserGet()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $response = $this->json('GET', 'api/user/shop/' . ShopControllerTest::$id,
            [], [
                'Authorization' => $tokenKey
            ]);

        $response->assertJsonStructure(['id', 'ownerId', 'brandName', 'latPos', 'logPos']);
    }

    public function testPutExisted()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $response = $this->json('PUT', 'api/shop/' . ShopControllerTest::$id,
            [
                'brandName' => 'Digital Minds Ltd',
                'latPos' => '12.34',
                'logPos' => '56.78'
            ], [
                'Authorization' => $tokenKey
            ]);

        // Check Structure
        $response->assertJsonStructure(['id', 'ownerId', 'brandName', 'latPos', 'logPos']);

        // Check Response Data from PUT call
        $this->assertEquals("Digital Minds Ltd", $response->decodeResponseJson()['brandName']);
        $this->assertEquals('12.34', $response->decodeResponseJson()['latPos']);
        $this->assertEquals('56.78', $response->decodeResponseJson()['logPos']);

        // Check Response Data from a GET call
        $responseGet = $this->json('GET', 'api/shop/' . ShopControllerTest::$id, [], []);
        $this->assertEquals("Digital Minds Ltd", $responseGet->decodeResponseJson()['brandName']);
        $this->assertEquals('12.34', $responseGet->decodeResponseJson()['latPos']);
        $this->assertEquals('56.78', $responseGet->decodeResponseJson()['logPos']);
    }

    public function testPutNotExisted()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $response = $this->json('PUT', 'api/shop/' . 99999,
            [
                'brandName' => 'Digital Minds Ltd',
                'latPos' => '12.34',
                'logPos' => '56.78'
            ], [
                'Authorization' => $tokenKey
            ]);

        $this->assertEquals("{\"message\":\"Shop not found\"}", $response->content());
    }

    public function testPutNotMine()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $response = $this->json('PUT', 'api/shop/2',
            [
                'brandName' => 'Digital Minds Ltd',
                'latPos' => '12.34',
                'logPos' => '56.78'
            ], [
                'Authorization' => $tokenKey
            ]);

        $response->assertStatus(401);
    }

    public function testPutInvalidLatLog()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $response = $this->json('PUT', 'api/shop/' . ShopControllerTest::$id,
            [
                'brandName' => 'Digital Minds Ltd',
                'latPos' => '456',
                'logPos' => '456'
            ], [
                'Authorization' => $tokenKey
            ]);

        $response->assertStatus(422);
    }

    public function testDeleteExisted()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $url = "api/shop/" . ShopControllerTest::$id;

        $response = $this->json('DELETE', $url,
            [],
            [
                'Authorization' => $tokenKey
            ]);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDeleteNotMine()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $url = "api/shop/2";

        $response = $this->json('DELETE', $url,
            [],
            [
                'Authorization' => $tokenKey
            ]);

        $this->assertEquals(401, $response->getStatusCode());
    }

    public function testDeleteNotExisted()
    {
        $token = new AuthForTests();
        $token->generateToken($this);
        $tokenKey = $token->getToken();

        $response = $this->json('DELETE', "api/shop/" . ShopControllerTest::$id,
            [],
            [
                'Authorization' => $tokenKey
            ]);


        $response->assertStatus(404);
    }

    public function testUserListNotAuth()
    {
        $response = $this->json('GET', 'api/user/shop', [], []);
        $response->assertStatus(401);
        $this->assertEquals("{\"message\":\"Unauthenticated.\"}", $response->content());
    }

    public function testUserGetNotAuth()
    {
        $response = $this->json('GET', 'api/user/shop/' . ShopControllerTest::$id, [], []);
        $response->assertStatus(401);
        $this->assertEquals("{\"message\":\"Unauthenticated.\"}", $response->content());
    }

    public function testPutNotAuth()
    {
        $response = $this->json('PUT', 'api/shop/' . ShopControllerTest::$id,
            [
                'brandName' => 'Digital Minds Ltd',
                'latPos' => '123.456',
                'logPos' => '234.567'
            ], []
        );
        $response->assertStatus(401);
        $this->assertEquals("{\"message\":\"Unauthenticated.\"}", $response->content());
    }

}