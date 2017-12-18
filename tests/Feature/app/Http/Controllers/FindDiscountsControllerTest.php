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
            'username' => 'TestUser@JNKSoftware.eu',
            'password' => '1234567'
        ]);

        findDiscountsControllerTest::$AuthValues=json_decode($response->getContent(),true);
        $response->assertStatus(200);


    }
//--------------------------------------------- TESTING  /findDiscounts---------------------------------------------------------------
    // i am using coordinates from googlemaps
    // 41.088591, 23.551272

    public function testEmptyFieldDistanceEndPointFindDiscounts()
    {
        $token=findDiscountsControllerTest::$AuthValues['access_token'];

        $response = $this->withHeader('Authorization','Bearer '.$token)->json('POST','api/user/findDiscounts', [

            'logPos' => '41.088591',
            'latPos' => '23.551272',
        ]);

        $response->assertJson([
            'errors'=>['distanceInMeters'=>['The distance in meters field is required.']]]);

    }


    public function testEmptyFieldLogPosEndPointFindDiscounts()
    {
        $token=findDiscountsControllerTest::$AuthValues['access_token'];

        $response = $this->withHeader('Authorization','Bearer '.$token)->json('POST','api/user/findDiscounts', [


            'latPos' => '23.551272',
             'distanceInMeters' => '1200'

        ]);

        $response->assertJson([
            'errors'=>['logPos'=>['The log pos field is required.']]]);

    }



    public function testEmptyFieldLatPosEndPointFindDiscounts()
    {
        $token=findDiscountsControllerTest::$AuthValues['access_token'];

        $response = $this->withHeader('Authorization','Bearer '.$token)->json('POST','api/user/findDiscounts', [

            'logPos' => '41.088591',
            'distanceInMeters' => '1200'

        ]);

        $response->assertJson([
            'errors'=>['latPos'=>['The lat pos field is required.']]]);

    }

    public function testEmptyAllFieldsEndPointFindDiscounts()
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

    public function testInvalidTypeDistanceEndPointFindDiscounts()
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

    public function testInvalidTypeLatPosEndPointFindDiscounts()
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


    public function testInvalidTypeLogPosEndPointFindDiscounts()
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

    public function testSuccessResponseEndPointFindDiscounts()
    {
        $token=findDiscountsControllerTest::$AuthValues['access_token'];

        $response = $this->withHeader('Authorization','Bearer '.$token)->json('POST','api/user/findDiscounts', [

            'logPos' => '41.088591',
            'latPos' => '23.551272',
            'distanceInMeters' => '99999'

        ]);

             // distance from shop 1100 meters
            //returns the values in  []
        $response->assertJsonStructure([['shopName', 'category', 'shortDescription', 'finalPrice','productImageURL','discountId','distance', 'shopLatPos', 'shopLogPos']]);

    }


    public function testOutOfRangeDiscountEndPointFindDiscounts()
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

    public function testRequestWithoutTokenEndPointFindDiscounts()
    {


        $response = $this->json('POST','api/user/findDiscounts', [

            'logPos' => '41.088591',
            'latPos' => '23.551272',
            'distanceInMeters' => '1200'

        ]);

        $response->assertJson(['message'=>'Unauthenticated.']);

    }

   //--------------------------------------------- TESTING  /getTopList---------------------------------------------------------------

    public function testEmptyFieldLogPosEndPointGetTopList()
    {
        $token=findDiscountsControllerTest::$AuthValues['access_token'];

        $response = $this->withHeader('Authorization','Bearer '.$token)->json('POST','api/user/findDiscounts', [


            'latPos' => '23.551272',


        ]);

        $response->assertJson([
            'errors'=>['logPos'=>['The log pos field is required.']]]);

    }



    public function testEmptyFieldLatPosEndPointGetTopList()
    {
        $token=findDiscountsControllerTest::$AuthValues['access_token'];

        $response = $this->withHeader('Authorization','Bearer '.$token)->json('POST','api/user/getTopList', [

            'logPos' => '41.088591',


        ]);

        $response->assertJson([
            'errors'=>['latPos'=>['The lat pos field is required.']]]);

    }

    public function testEmptyAllFieldsEndPointGetTopList()
    {
        $token=findDiscountsControllerTest::$AuthValues['access_token'];

        $response = $this->withHeader('Authorization','Bearer '.$token)->json('POST','api/user/getTopList', [


        ]);


        $response->assertJson([
            'errors'=>[
                'logPos'=>['The log pos field is required.'],
                'latPos'=>['The lat pos field is required.']]]);


    }



    public function testInvalidTypeLatPosEndPointGetTopList()
    {
        $token=findDiscountsControllerTest::$AuthValues['access_token'];

        $response = $this->withHeader('Authorization','Bearer '.$token)->json('POST','api/user/getTopList', [

            'logPos' => '41.088591',
            'latPos' => 'sssssss',

        ]);

        $response->assertJson([
            'errors'=>['latPos'=>['The lat pos must be a number.']]]);


    }


    public function testInvalidTypeLogPosEndPointGetTopList()
    {
        $token=findDiscountsControllerTest::$AuthValues['access_token'];

        $response = $this->withHeader('Authorization','Bearer '.$token)->json('POST','api/user/getTopList', [

            'logPos' => 'aaaaaaaa',
            'latPos' => '23.551272',

        ]);

        $response->assertJson([
            'errors'=>['logPos'=>['The log pos must be a number.']]]);


    }

    public function testSuccessResponseEndPointGetTopList()
    {
        $token=findDiscountsControllerTest::$AuthValues['access_token'];

        $response = $this->withHeader('Authorization','Bearer '.$token)->json('POST','api/user/getTopList', [

            'logPos' => '41',
            'latPos' => '23',

        ]);


        var_dump($response);

        //returns the values in  []
        $response->assertJsonStructure([['shopName', 'category', 'shortDescription', 'finalPrice','productImageURL','discountId','distance', 'shopLatPos', 'shopLogPos']]);

    }


    public function testRequestWithoutTokenEndPointGetTopList()
    {


        $response = $this->json('POST','api/user/getTopList', [

            'logPos' => '41.088591',
            'latPos' => '23.551272',

        ]);

        $response->assertJson(['message'=>'Unauthenticated.']);

    }


}
