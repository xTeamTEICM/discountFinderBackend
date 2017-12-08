<?php

namespace App\Http\Controllers;


use App\CustomClasses\Distance;
use App\Shop;


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

        ]);

        $MaxDistance=request('distanceInMeters');
        $id=auth('api')->user()->id;
        $discounts=DB::select("call getMatchedDiscounts($id)");
        $requestedDiscounts =collect();


        foreach ($discounts as $discount){

            $shopLogPos =Shop::query()->where('id',$discount->shopId)->pluck('logPos')->first();
            $shopLatPos =Shop::query()->where('id',$discount->shopId)->pluck('latPos')->first();
            $distanceObject= new Distance(request('latPos'),request('logPos'));
            $distance=  $distanceObject->calculateDistanceInMeters($shopLatPos,$shopLogPos);


            if($distance<=$MaxDistance){
                //TODO find solution to remove this Global variable
                \App\Http\Resources\Discounts::$distance[]=$distance;
                $requestedDiscounts->push($discount) ;
            }
        }

        return new DiscountsCollection($requestedDiscounts);

    }



    public function TopList(Request $request)
    {
        $this->validate($request,[

            'logPos' => 'required|numeric',
            'latPos' => 'required|numeric'
        ]);

       //searching for Top 10 discounts
        //we need to add City field on Shop table because we are searching for All Discounts
        $discounts=DB::select("call getTopDiscounts(10)");
        $topList =collect();


        foreach ($discounts as $discount){

            $shopLogPos =Shop::query()->where('id',$discount->shopId)->pluck('logPos')->first();
            $shopLatPos =Shop::query()->where('id',$discount->shopId)->pluck('latPos')->first();
            $distanceObject= new Distance(request('latPos'),request('logPos'));
            $distance=  $distanceObject->calculateDistanceInMeters($shopLatPos,$shopLogPos);

           //default search at 3000 meters
            if($distance<=3000) {
                \App\Http\Resources\Discounts::$distance[]=$distance;
                $topList->push($discount) ;
            }
        }
        return new DiscountsCollection($topList);


    }









}
