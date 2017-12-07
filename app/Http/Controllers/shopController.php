<?php

namespace App\Http\Controllers;

use App\Shop;
use Illuminate\Http\Request;


class shopController extends Controller
{
    public function list()
    {
        return "[
                    {
                        \"id\": 1,
                        \"ownerId\": 2,
                        \"brandName\": \"SomeShop\",
                        \"logPos\": 11,
                        \"latPos\": 22
                    },
                    {
                        \"id\": 3,
                        \"ownerId\": 1,
                        \"brandName\": \"AEK\",
                        \"logPos\": 54,
                        \"latPos\": 45
                    },
                    {
                        \"id\": 4,
                        \"ownerId\": 2,
                        \"brandName\": \"mamasPizza\",
                        \"logPos\": 41.082279,
                        \"latPos\": 23.543239
                    },
                    {
                        \"id\": 5,
                        \"ownerId\": 2,
                        \"brandName\": \"KILIKIO TEI\",
                        \"logPos\": 41.074879,
                        \"latPos\": 23.553681
                    },
                    {
                        \"id\": 12,
                        \"ownerId\": 29,
                        \"brandName\": \"TechLimitTV.eu\",
                        \"logPos\": 25.15,
                        \"latPos\": 27.63
                    },
                    {
                        \"id\": 13,
                        \"ownerId\": 30,
                        \"brandName\": \"JNK Software Ltd\",
                        \"logPos\": 11,
                        \"latPos\": 22.63
                    },
                    {
                        \"id\": 26,
                        \"ownerId\": 41,
                        \"brandName\": \"mpaokia\",
                        \"logPos\": 21.38,
                        \"latPos\": 12.211
                    },
                    {
                        \"id\": 36,
                        \"ownerId\": 41,
                        \"brandName\": \"ditoUpdated\",
                        \"logPos\": 45,
                        \"latPos\": 45
                    },
                    {
                        \"id\": 37,
                        \"ownerId\": 13,
                        \"brandName\": \"dito\",
                        \"logPos\": 34,
                        \"latPos\": 32
                    },
                    {
                        \"id\": 38,
                        \"ownerId\": 41,
                        \"brandName\": \"dito3\",
                        \"logPos\": 43,
                        \"latPos\": 43
                    },
                    {
                        \"id\": 40,
                        \"ownerId\": 41,
                        \"brandName\": \"δελης-πουθενας\",
                        \"logPos\": 22,
                        \"latPos\": 45
                    }
                ]";
    }

    public function myList()
    {
        return "[
                    {
                        \"id\": 1,
                        \"ownerId\": 2,
                        \"brandName\": \"SomeShop\",
                        \"logPos\": 11,
                        \"latPos\": 22
                    },
                    {
                        \"id\": 3,
                        \"ownerId\": 1,
                        \"brandName\": \"AEK\",
                        \"logPos\": 54,
                        \"latPos\": 45
                    },
                    {
                        \"id\": 4,
                        \"ownerId\": 2,
                        \"brandName\": \"mamasPizza\",
                        \"logPos\": 41.082279,
                        \"latPos\": 23.543239
                    },
                    {
                        \"id\": 5,
                        \"ownerId\": 2,
                        \"brandName\": \"KILIKIO TEI\",
                        \"logPos\": 41.074879,
                        \"latPos\": 23.553681
                    },
                    {
                        \"id\": 12,
                        \"ownerId\": 29,
                        \"brandName\": \"TechLimitTV.eu\",
                        \"logPos\": 25.15,
                        \"latPos\": 27.63
                    },
                    {
                        \"id\": 13,
                        \"ownerId\": 30,
                        \"brandName\": \"JNK Software Ltd\",
                        \"logPos\": 11,
                        \"latPos\": 22.63
                    },
                    {
                        \"id\": 26,
                        \"ownerId\": 41,
                        \"brandName\": \"mpaokia\",
                        \"logPos\": 21.38,
                        \"latPos\": 12.211
                    },
                    {
                        \"id\": 36,
                        \"ownerId\": 41,
                        \"brandName\": \"ditoUpdated\",
                        \"logPos\": 45,
                        \"latPos\": 45
                    },
                    {
                        \"id\": 37,
                        \"ownerId\": 13,
                        \"brandName\": \"dito\",
                        \"logPos\": 34,
                        \"latPos\": 32
                    },
                    {
                        \"id\": 38,
                        \"ownerId\": 41,
                        \"brandName\": \"dito3\",
                        \"logPos\": 43,
                        \"latPos\": 43
                    },
                    {
                        \"id\": 40,
                        \"ownerId\": 41,
                        \"brandName\": \"δελης-πουθενας\",
                        \"logPos\": 22,
                        \"latPos\": 45
                    }
                ]";
    }

    public function get($id)
    {
        return "{
                    \"id\": $id,
                    \"ownerId\": 2,
                    \"brandName\": \"SomeShop\",
                    \"logPos\": 11,
                    \"latPos\": 22
                }";
    }

    public function myGet($id)
    {
        return "{
                    \"id\": $id,
                    \"ownerId\": 2,
                    \"brandName\": \"SomeShop\",
                    \"logPos\": 11,
                    \"latPos\": 22
                }";
    }

    public function post(Request $request)
    {

        $user = auth('api')->user();

        $data = $this->validate($request, [
            'brandName' => 'required|string|unique:shops',
            'logPos' => 'required|numeric',
            'latPos' => 'required|numeric'
        ]);

        $shop = new Shop();

        $shop->ownerId = $user->id;
        $shop->brandName = $data['brandName'];
        $shop->logPos = $data['logPos'];
        $shop->latPos = $data['latPos'];

        return $shop;

    }

    public function update(Request $request)
    {

        $user = auth('api')->user();

        $data = $this->validate($request, [
            'id' => 'required|integer',
            'brandName' => 'required|string',
            'logPos' => 'required|numeric',
            'latPos' => 'required|numeric'
        ]);

        $shop = new Shop();

        if($shop) {
            $shop->brandName = $data['brandName'];
            $shop->logPos = $data['logPos'];
            $shop->latPos = $data['latPos'];

            return $shop;
        }
    }

    public function delete($id)
    {
        // ToDo ???
    }
}
