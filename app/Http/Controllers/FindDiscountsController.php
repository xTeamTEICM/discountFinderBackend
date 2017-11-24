<?php

namespace App\Http\Controllers;


use App\Discounts;


use Illuminate\Http\Request;
use App\Http\Resources\DiscountsCollection ;
use Illuminate\Support\Facades\DB;


class findDiscountsController extends Controller
{



    public function list(Request $request)
    {
        $this->validate($request,[

            'logPos' => 'required|numeric',
            'latPos' => 'required|numeric',
            'distanceInMeters' => 'required|numeric'

        ]);


        return new DiscountsCollection($this->shopsAtCertainDistance(request('distanceInMeters')));

    }






    //TODO we should not take all discounts from database and   edit them here
    public function  shopsAtCertainDistance($maxDistance){

       $discounts=Discounts::all();
        $discountsSorted =collect();
        foreach ($discounts as $discount){
            $shopLogPos =DB::table('shops')->where('id',$discount->shopId)->pluck('logPos')->first();
            $shopLatPos =DB::table('shops')->where('id',$discount->shopId)->pluck('latPos')->first();

            $distance=  $this->calculateDistanceInMeters(request('latPos'),request('logPos'),$shopLogPos,$shopLatPos);



             if($distance<$maxDistance){
                 \App\Http\Resources\Discounts::$distance[]=$distance;
                 $discountsSorted->push($discount) ;
             }

        }

         return $discountsSorted;

    }



    public function calculateDistanceInMeters($userLatPos,$userLogPos,$shopLogPosition,$shopLatPosition){
        $userLatPos=deg2rad($userLatPos);
        $userLogPos=deg2rad($userLogPos);
        $shopLogPosition=deg2rad($shopLogPosition);
        $shopLatPosition=deg2rad($shopLatPosition);


        $radiusOfEarth = 6371000;// Earth's radius in meters.
        $diffLatitude = abs($userLatPos - $shopLatPosition);
        $diffLongitude = abs($userLogPos - $shopLogPosition);



        $a = sin($diffLatitude / 2) * sin($diffLatitude / 2) +
            cos($userLatPos) * cos($shopLatPosition) *
            sin($diffLongitude / 2) * sin($diffLongitude / 2);
        $c = 2 * asin(sqrt($a));
        $distance = $radiusOfEarth * $c;

        return (int)$distance;


    }

}
