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
            'distanceInMeters' => 'required|numeric',
            'maxPrice' => 'nullable|numeric',
            'category' => 'nullable|numeric',

        ]);


        return new DiscountsCollection($this->requestedDiscounts(request('distanceInMeters'),request('maxPrice'),request('category')));

    }


    public function  requestedDiscounts($maxDistance,$maxPrice,$category){

        $maxPrice=$this->optimizePrice($maxPrice);
        $discounts=Discounts::all();
        $requestedDiscounts =collect();


        foreach ($discounts as $discount){
            $shopLogPos =DB::table('shops')->where('id',$discount->shopId)->pluck('logPos')->first();
            $shopLatPos =DB::table('shops')->where('id',$discount->shopId)->pluck('latPos')->first();
            $distance=  $this->calculateDistanceInMeters(request('latPos'),request('logPos'),$shopLogPos,$shopLatPos);


            if($category!=null){

               if($distance<=$maxDistance&&$discount->currentPrice<=$maxPrice&&$category==$discount->category){
                   \App\Http\Resources\Discounts::$distance[]=$distance;
                   $requestedDiscounts->push($discount) ;
                }
              }
              else{

                  if($distance<=$maxDistance&&$discount->currentPrice<=$maxPrice){
                      \App\Http\Resources\Discounts::$distance[]=$distance;
                      $requestedDiscounts->push($discount) ;
                  }

              }
        }
        return $requestedDiscounts;
    }



//seting big default maxprice if maxprice is null so we can take all prices
    public function optimizePrice($maxPrice){
        if($maxPrice==null){
            $maxPrice=1000000;
        }
        return $maxPrice;


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
