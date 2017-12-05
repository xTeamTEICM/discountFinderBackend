<?php


namespace Tests\Feature;

use Tests\TestCase;

class findDiscountsControllerTest extends TestCase
{

    //TODO just a sample i need to make more tests
    protected static $AuthValues;

    // i am using coordinates from googlemaps
    // 41.088591, 23.551272




    public function testGetAuthValuesFromStaticUser()
    {

        $response = $this->json('POST', 'api/login', [
            'username' => 't@test.com',
            'password' => '123456'
        ]);

        findDiscountsControllerTest::$AuthValues=json_decode($response->getContent(),true);
        $response->assertStatus(200);


    }

    public function testEmptyFieldDistance()
    {
        $token=findDiscountsControllerTest::$AuthValues['access_token'];

        $response = $this->withHeader('Authorization','Bearer '.$token)->json('POST','api/user/findDiscounts', [

            'logPos' => '41.088591',
            'latPos' => '23.551272',
        ]);

        $response->assertJson([
            'errors'=>['distanceInMeters'=>['The distance in meters field is required.']]]);

    }


    public function testEmptyFieldLogPos()
    {
        $token=findDiscountsControllerTest::$AuthValues['access_token'];

        $response = $this->withHeader('Authorization','Bearer '.$token)->json('POST','api/user/findDiscounts', [


            'latPos' => '23.551272',
             'distanceInMeters' => '1200'

        ]);

        $response->assertJson([
            'errors'=>['logPos'=>['The log pos field is required.']]]);

    }



    public function testEmptyFieldLatPos()
    {
        $token=findDiscountsControllerTest::$AuthValues['access_token'];

        $response = $this->withHeader('Authorization','Bearer '.$token)->json('POST','api/user/findDiscounts', [

            'logPos' => '41.088591',
            'distanceInMeters' => '1200'

        ]);

        $response->assertJson([
            'errors'=>['latPos'=>['The lat pos field is required.']]]);

    }

    public function testEmptyAllFields()
    {
        $token=findDiscountsControllerTest::$AuthValues['access_token'];

        $response = $this->withHeader('Authorization','Bearer '.$token)->json('POST','api/user/findDiscounts', [


        ]);


        $response->assertJson([
            'errors'=>[
                'distanceInMeters'=> ['The distance in meters field is required.'],
                'logPos'=>['The log pos field is required.'],
                'latPos'=>['The lat pos field is required.']]]);


    }

    public function testInvalidTypeDistance()
    {
        $token=findDiscountsControllerTest::$AuthValues['access_token'];

        $response = $this->withHeader('Authorization','Bearer '.$token)->json('POST','api/user/findDiscounts', [

            'logPos' => '41.088591',
            'latPos' => '23.551272',
            'distanceInMeters' => 'asdsdds'

        ]);

        $response->assertJson([
            'errors'=>['distanceInMeters'=>['The distance in meters must be a number.']]]);


    }

    public function testInvalidTypeLatPos()
    {
        $token=findDiscountsControllerTest::$AuthValues['access_token'];

        $response = $this->withHeader('Authorization','Bearer '.$token)->json('POST','api/user/findDiscounts', [

            'logPos' => '41.088591',
            'latPos' => 'sssssss',
            'distanceInMeters' => '1200'

        ]);

        $response->assertJson([
            'errors'=>['latPos'=>['The lat pos must be a number.']]]);


    }


    public function testInvalidTypeLogPos()
    {
        $token=findDiscountsControllerTest::$AuthValues['access_token'];

        $response = $this->withHeader('Authorization','Bearer '.$token)->json('POST','api/user/findDiscounts', [

            'logPos' => 'aaaaaaaa',
            'latPos' => '23.551272',
            'distanceInMeters' => '1200'

        ]);

        $response->assertJson([
            'errors'=>['logPos'=>['The log pos must be a number.']]]);


    }

    public function testSuccessResponse()
    {
        $token=findDiscountsControllerTest::$AuthValues['access_token'];

        $response = $this->withHeader('Authorization','Bearer '.$token)->json('POST','api/user/findDiscounts', [

            'logPos' => '41.088591',
            'latPos' => '23.551272',
            'distanceInMeters' => '1200'

        ]);

             // distance from shop 1100 meters
            //returns the values in  []
        $response->assertJsonStructure([['shopName', 'category', 'shortDescription', 'finalPrice','productImageURL','discountId','distance']]);

    }


    public function testOutOfRangeDiscount()
    {
        $token=findDiscountsControllerTest::$AuthValues['access_token'];

        $response = $this->withHeader('Authorization','Bearer '.$token)->json('POST','api/user/findDiscounts', [

            'logPos' => '41.088591',
            'latPos' => '23.551272',
            'distanceInMeters' => '1000'

        ]);

        // distance from shop 1100 meters
        $response->assertJsonStructure(null);

    }

    public function testRequestWithoutToken()
    {


        $response = $this->json('POST','api/user/findDiscounts', [

            'logPos' => '41.088591',
            'latPos' => '23.551272',
            'distanceInMeters' => '1200'

        ]);

        $response->assertJson(['message'=>'Unauthenticated.']);

    }



}
