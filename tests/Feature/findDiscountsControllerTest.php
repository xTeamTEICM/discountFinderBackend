<?php


namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class findDiscountsControllerTest extends TestCase
{

  //TODO just a sample i need to make more tests
    protected static $AuthValues;

   //we dont test this function but we need it to get authvalues for the tests
    public function testGetAuthValuesFromStaticUser()
    {

        $response = $this->json('POST', 'api/login', [
            'username' => 'testing@local.host',
            'password' => '1234567'
        ]);

        findDiscountsControllerTest::$AuthValues=json_decode($response->getContent(),true);
        $response->assertStatus(200);

    }



    public function testFindDiscountsWithFailUserCoordinates(){
        $token=findDiscountsControllerTest::$AuthValues['access_token'];

        $response= $this->withHeader('Authorization','Bearer ' . $token)->json('POST','api/user/findDiscounts', [

            'logPos' => '23221',
            'latPos' => '1234'

        ]);

        $response->assertJsonStructure(null);
    }

















}
