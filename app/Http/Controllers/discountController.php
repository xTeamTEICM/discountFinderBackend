<?php

namespace App\Http\Controllers;

use App\Discount;
use Illuminate\Http\Request;


class discountController extends Controller
{
    public function list(){

        return "[
                    {
                        \"id\": 1,
                        \"shopId\": 1,
                        \"category\": 1,
                        \"originalPrice\": 200,
                        \"currentPrice\": 50,
                        \"description\": \"someDesc\",
                        \"image\": \"http://img.youtube.com/\"
                    },
                    {
                        \"id\": 2,
                        \"shopId\": 3,
                        \"category\": 1,
                        \"originalPrice\": 665455000000,
                        \"currentPrice\": 0.1,
                        \"description\": \"cxv\",
                        \"image\": \"http://img.youtube.com/\"
                    },
                    {
                        \"id\": 3,
                        \"shopId\": 4,
                        \"category\": 4,
                        \"originalPrice\": 10,
                        \"currentPrice\": 5,
                        \"description\": \"pizza margarita\",
                        \"image\": \"http://img.youtube.com/\"
                    },
                    {
                        \"id\": 4,
                        \"shopId\": 5,
                        \"category\": 4,
                        \"originalPrice\": 50,
                        \"currentPrice\": 30,
                        \"description\": \"10 pizzes \",
                        \"image\": \"http://img.youtube.com/\"
                    },
                    {
                        \"id\": 5,
                        \"shopId\": 3,
                        \"category\": 1,
                        \"originalPrice\": 23432,
                        \"currentPrice\": 23423,
                        \"description\": \"rwer\",
                        \"image\": \"werwerwe\"
                    },
                    {
                        \"id\": 6,
                        \"shopId\": 4,
                        \"category\": 4,
                        \"originalPrice\": 7,
                        \"currentPrice\": 3,
                        \"description\": \"tsampa\",
                        \"image\": \"http://img.youtube.com/\"
                    }
                ]";

    }


    public function get($id){

        return "{
                    \"id\": $id,
                    \"shopId\": 1,
                    \"category\": 1,
                    \"originalPrice\": 200,
                    \"currentPrice\": 50,
                    \"description\": \"someDesc\",
                    \"image\": \"http://img.youtube.com/\"
                }";



    }

    public function post(Request $request){

        $data = $this->validate($request, [

            'category' => 'required|numeric',
            'originalPrice' => 'required|numeric',
            'currentPrice' => 'required|numeric',
            'description' => 'required|string',
            'image' => 'required|string'
        ]);

        //trexei alla den ksero giati, einai arga kleinoun ta matia, i need coffeeeeeeeeeee


        $discount = new Discount();
        $discount->shopId = 1;
        $discount->category = $data['category'];
        $discount->originalPrice = $data['originalPrice'];
        $discount->currentPrice = $data['currentPrice'];
        $discount->description = $data['description'];
        $discount->image = $data['image'];

        return $discount;


    }


    public function put($id, Request $request){

        $request['id'] = $id;

        $data = $this->validate($request, [

            'id' => 'required|numeric',
            'category' => 'required|numeric',
            'originalPrice' => 'required|numeric',
            'currentPrice' => 'required|numeric',
            'description' => 'required|string',
            'image' => 'required|string'
        ]);

        $discount = new Discount();
        $discount->shopId = 1;
        $discount->category = $data['category'];
        $discount->originalPrice = $data['originalPrice'];
        $discount->currentPrice = $data['currentPrice'];
        $discount->description = $data['description'];
        $discount->image = $data['image'];

        return $discount;
    }


    public function delete($id)
    {
        // ToDo ???
    }


}
