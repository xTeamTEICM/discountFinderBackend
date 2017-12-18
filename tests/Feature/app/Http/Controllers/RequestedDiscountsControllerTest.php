<?php

namespace Tests\Feature;

use Tests\TestCase;

class requestedDiscountsControllerTest extends TestCase
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

        requestedDiscountsControllerTest::$Token_Type = $response->decodeResponseJson()['token_type'];
        requestedDiscountsControllerTest::$Access_Token = $response->decodeResponseJson()['access_token'];

        $this->assertNotEquals("", requestedDiscountsControllerTest::$Token_Type);
        $this->assertNotEquals("", requestedDiscountsControllerTest::$Access_Token);
    }

    public function testPostNotExisted()
    {
        $response = $this->json('POST', 'api/requestedDiscount', [
            'category' => '1',
            'price' => '999',
            'tags' => 'testingAPI'
        ], [
            'Authorization' => requestedDiscountsControllerTest::$Token_Type . " " . requestedDiscountsControllerTest::$Access_Token
        ]);

        requestedDiscountsControllerTest::$id = $response->decodeResponseJson()['id'];

        $response->assertJsonStructure(['userId', 'category', 'price', 'tags', 'id']);
    }

    public function testList()
    {
        $response = $this->json('GET', 'api/requestedDiscount', [], [
            'Authorization' => requestedDiscountsControllerTest::$Token_Type . " " . requestedDiscountsControllerTest::$Access_Token
        ]);
        $response->assertJsonStructure([['userId', 'category', 'price', 'tags', 'id', 'categoryTitle']]);
    }

    public function testGetExisted()
    {
        $response = $this->json('GET', 'api/requestedDiscount/' . requestedDiscountsControllerTest::$id, [], [
            'Authorization' => requestedDiscountsControllerTest::$Token_Type . " " . requestedDiscountsControllerTest::$Access_Token
        ]);
        $response->assertJsonStructure(['id', 'userId', 'category', 'price', 'tags', 'categoryTitle']);
    }

    public function testGetNotExisted()
    {
        $response = $this->json('GET', 'api/requestedDiscount/0', [], [
            'Authorization' => requestedDiscountsControllerTest::$Token_Type . " " . requestedDiscountsControllerTest::$Access_Token
        ]);
        $this->assertEquals("", $response->content());
    }

    public function testPutExisted()
    {
        $response = $this->json('PUT', 'api/requestedDiscount/' . requestedDiscountsControllerTest::$id, [
            'category' => '1',
            'price' => '999',
            'tags' => 'testingAPI2'
        ], [
            'Authorization' => requestedDiscountsControllerTest::$Token_Type . " " . requestedDiscountsControllerTest::$Access_Token
        ]);
        $response->assertJsonStructure(['id', 'userId', 'category', 'price', 'tags']);

        // Check Response Data from PUT call
        $this->assertEquals("1", $response->decodeResponseJson()['category']);
        $this->assertEquals('999', $response->decodeResponseJson()['price']);
        $this->assertEquals('testingAPI2', $response->decodeResponseJson()['tags']);

        // Check Response Data from a GET call
        $responseGet = $this->json('GET', 'api/requestedDiscount/' . requestedDiscountsControllerTest::$id, [], []);
        $this->assertEquals("1", $responseGet->decodeResponseJson()['category']);
        $this->assertEquals('999', $responseGet->decodeResponseJson()['price']);
        $this->assertEquals('testingAPI2', $responseGet->decodeResponseJson()['tags']);
    }

    public function testPutNotExisted()
    {
        $response = $this->json('PUT', 'api/requestedDiscount/0', [
            'category' => '1',
            'price' => '999',
            'tags' => 'testingAPI2'
        ], [
            'Authorization' => requestedDiscountsControllerTest::$Token_Type . " " . requestedDiscountsControllerTest::$Access_Token
        ]);
        $this->assertEquals("", $response->content());
    }


    public function testDeleteNotExisted()
    {
        $responseTrue = $this->json('DELETE', "api/requestedDiscount/" . requestedDiscountsControllerTest::$id,
            [],
            [
                'Authorization' => requestedDiscountsControllerTest::$Token_Type . " " . requestedDiscountsControllerTest::$Access_Token
            ]);

        $this->assertEquals(200, $responseTrue->getStatusCode());
    }
}
