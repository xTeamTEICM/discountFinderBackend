<?php

namespace App\Http\Controllers;


use App\Discounts;


use Illuminate\Http\Request;
use App\Http\Resources\DiscountsCollection ;
use Illuminate\Support\Facades\DB;


class findDiscountsController extends Controller
{

protected $distanceObject;

    public function listOfDiscounts(Request $request)
    {
        $this->validate($request,[

            'logPos' => 'required|numeric',
            'latPos' => 'required|numeric'

        ]);

        $discounts=Discounts::all();
        return new DiscountsCollection($discounts);

    }





    public function calculateDistance($userLatPos,$userLogPos,$shopLogPosition,$shopLatPosition){

        $subtractionX = abs($userLatPos - $shopLatPosition);
        $subtractionY = abs($userLogPos - $shopLogPosition);

        $distance = sqrt((pow($subtractionX, 2)) + (pow($subtractionY, 2)));


        return $distance;


    }

}
