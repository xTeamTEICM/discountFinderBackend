<?php

namespace App\Http\Controllers;

use App\requestedDiscount;
use Illuminate\Http\Request;


class requestedDiscountController extends Controller
{
    public function list()
    {
        return "[
                    {
                        \"id\": 37,
                        \"userId\": 30,
                        \"category\": 1,
                        \"price\": 50,
                        \"tags\": \"Sample, Demo, App, Data\",
                        \"image\": \"http://img.youtube.com/\",
                        \"categoryTitle\": \"Computer\"
                    }
                ]";

    }

    public function get($id)
    {
        return "{
                    \"id\": 37,
                    \"userId\": 30,
                    \"category\": 1,
                    \"price\": 50,
                    \"tags\": \"Sample, Demo, App, Data\",
                    \"image\": \"http://img.youtube.com/\",
                    \"categoryTitle\": \"Computer\"
                }";
    }

    public function post(Request $request)
    {

        $data = $this->validate($request, [
            'category' => 'required|numeric',
            'price' => 'required|numeric',
            'tags' => 'required|string'
        ]);

        $requestedDiscount = new requestedDiscount();
        $requestedDiscount->userId = 1;
        $requestedDiscount->category = $data['category'];
        $requestedDiscount->price = $data['price'];
        $requestedDiscount->tags = $data['tags'];

        return $requestedDiscount;
    }

    public function put($id, Request $request)
    {
        $request['id'] = $id;

        $data = $this->validate($request, [
            'id' => 'required|numeric',
            'category' => 'required|numeric',
            'price' => 'required|numeric',
            'tags' => 'required|string'
        ]);


        $requestedDiscount = new requestedDiscount();
        if ($requestedDiscount != null) {
            $requestedDiscount->category = $data['category'];
            $requestedDiscount->price = $data['price'];
            $requestedDiscount->tags = $data['tags'];

            return $requestedDiscount;
        } else {
            return "";
        }
    }

    public function delete($id)
    {
        // ToDo ???
    }
}
