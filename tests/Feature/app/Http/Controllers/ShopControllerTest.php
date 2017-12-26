<?php

namespace Tests\Feature;


use Tests\TestCase;

class ShopControllerTest extends TestCase
{
    protected static $Token_Type;
    protected static $Access_Token;
    protected static $id;

    public function testAuth()
    {
        $response = $this->json('POST', 'api/login', [
            'username' => 'TestUser@JNKSoftware.eu',
            'password' => '1234567'
        ]);

        ShopControllerTest::$Token_Type = $response->decodeResponseJson()['token_type'];
        ShopControllerTest::$Access_Token = $response->decodeResponseJson()['access_token'];

        $this->assertNotEquals("", ShopControllerTest::$Token_Type);
        $this->assertNotEquals("", ShopControllerTest::$Access_Token);
    }

    public function testPostNotExisted()
    {
        $response = $this->json('POST', 'api/shop', [
            'brandName' => 'TestingShop',
            'logPos' => '12.34',
            'latPos' => '23.45'
        ], [
            'Authorization' => ShopControllerTest::$Token_Type . " " . ShopControllerTest::$Access_Token
        ]);

        ShopControllerTest::$id = $response->decodeResponseJson()['id'];

        $response->assertJsonStructure(['ownerId', 'brandName', 'logPos', 'latPos']);
    }

    public function testPostExisted()
    {
        $response = $this->json('POST', 'api/shop', [
            'brandName' => 'TestingShop',
            'logPos' => '12.34',
            'latPos' => '23.45'
        ], [
            'Authorization' => ShopControllerTest::$Token_Type . " " . ShopControllerTest::$Access_Token
        ]);

        $this->assertEquals(
            "{\"message\":\"The given data was invalid.\",\"errors\":{\"brandName\":[\"The brand name has already been taken.\"]}}",
            $response->content()
        );
    }

    public function testList()
    {
        $response = $this->json('GET', 'api/shop', [], []);
        $response->assertJsonStructure([['id', 'ownerId', 'brandName', 'latPos', 'logPos']]) or $response->assertJson([]);
    }

    public function testMyDiscountsShopExist()
    {
        $response = $this->json('GET', 'api/user/shop/' . ShopControllerTest::$id . '/discounts', [], [
            'Authorization' => ShopControllerTest::$Token_Type . " " . ShopControllerTest::$Access_Token
        ]);

        $response->assertStatus(200);
    }

    public function testMyDiscountsShopNotExist()
    {
        $response = $this->json('GET', 'api/user/shop/' . '9898989' . '/discounts', [], [
            'Authorization' => ShopControllerTest::$Token_Type . " " . ShopControllerTest::$Access_Token
        ]);

        $response->assertStatus(404);
    }

    public function testGetExisted()
    {
        $response = $this->json('GET', 'api/shop/' . ShopControllerTest::$id, [], []);
        $response->assertJsonStructure(['id', 'ownerId', 'brandName', 'latPos', 'logPos']);
    }

    public function testGetNotExisted()
    {
        $response = $this->json('GET', 'api/shop/0', [], []);
        $this->assertEquals("", $response->content());
    }

    public function testUserList()
    {
        $response = $this->json('GET', 'api/user/shop',
            [], [
                'Authorization' => ShopControllerTest::$Token_Type . " " . ShopControllerTest::$Access_Token
            ]);

        $response->assertJsonStructure([['id', 'ownerId', 'brandName', 'latPos', 'logPos']]);
    }

    public function testUserGet()
    {
        $response = $this->json('GET', 'api/user/shop/' . ShopControllerTest::$id,
            [], [
                'Authorization' => ShopControllerTest::$Token_Type . " " . ShopControllerTest::$Access_Token
            ]);

        $response->assertJsonStructure(['id', 'ownerId', 'brandName', 'latPos', 'logPos']);
    }

    public function testPutExisted()
    {
        $response = $this->json('PUT', 'api/shop/' . ShopControllerTest::$id,
            [
                'brandName' => 'Digital Minds Ltd',
                'latPos' => '123.456',
                'logPos' => '234.567'
            ], [
                'Authorization' => ShopControllerTest::$Token_Type . " " . ShopControllerTest::$Access_Token
            ]);

        // Check Structure
        $response->assertJsonStructure(['id', 'ownerId', 'brandName', 'latPos', 'logPos']);

        // Check Response Data from PUT call
        $this->assertEquals("Digital Minds Ltd", $response->decodeResponseJson()['brandName']);
        $this->assertEquals('123.456', $response->decodeResponseJson()['latPos']);
        $this->assertEquals('234.567', $response->decodeResponseJson()['logPos']);

        // Check Response Data from a GET call
        $responseGet = $this->json('GET', 'api/shop/' . ShopControllerTest::$id, [], []);
        $this->assertEquals("Digital Minds Ltd", $responseGet->decodeResponseJson()['brandName']);
        $this->assertEquals('123.456', $responseGet->decodeResponseJson()['latPos']);
        $this->assertEquals('234.567', $responseGet->decodeResponseJson()['logPos']);
    }

    public function testPutNotExisted()
    {
        $response = $this->json('PUT', 'api/shop/' . 99999,
            [
                'brandName' => 'Digital Minds Ltd',
                'latPos' => '123.456',
                'logPos' => '234.567'
            ], [
                'Authorization' => ShopControllerTest::$Token_Type . " " . ShopControllerTest::$Access_Token
            ]);

        $this->assertEquals("{\"message\":\"Shop not found\"}", $response->content());
    }

    public function testDeleteExisted()
    {
        $url = "api/shop/" . ShopControllerTest::$id;

        $response = $this->json('DELETE', $url,
            [],
            [
                'Authorization' => ShopControllerTest::$Token_Type . " " . ShopControllerTest::$Access_Token
            ]);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDeleteNotExisted()
    {
        $responseTrue = $this->json('DELETE', "api/shop/" . ShopControllerTest::$id,
            [],
            [
                'Authorization' => ShopControllerTest::$Token_Type . " " . ShopControllerTest::$Access_Token
            ]);

        $this->assertEquals(404, $responseTrue->getStatusCode());
    }

    public function testUserListNotAuth()
    {
        $response = $this->json('GET', 'api/user/shop', [], []);

        $this->assertEquals("{\"message\":\"Unauthenticated.\"}", $response->content());
    }

    public function testUserGetNotAuth()
    {
        $response = $this->json('GET', 'api/user/shop/' . ShopControllerTest::$id, [], []);
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
        $this->assertEquals("{\"message\":\"Unauthenticated.\"}", $response->content());
    }

}