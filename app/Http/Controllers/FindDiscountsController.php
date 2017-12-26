<?php

namespace App\Http\Controllers;


use App\CustomClasses\Distance;
use App\Http\Resources\DiscountsCollection;
use App\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class findDiscountsController extends Controller
{

    /**
     * @param Request $request
     * @return DiscountsCollection
     */
    public function list(Request $request)
    {
        $data = $this->validate($request, [
            'logPos' => 'required|numeric',
            'latPos' => 'required|numeric',
            'distanceInMeters' => 'required|numeric',
        ]);

        $MaxDistance = $data['distanceInMeters'];
        $id = auth('api')->user()->id;
        $discounts = DB::select("call getMatchedDiscounts($id)");
        $requestedDiscounts = collect();

        foreach ($discounts as $discount) {
            $shopLogPos = Shop::query()->where('id', $discount->shopId)->pluck('logPos')->first();
            $shopLatPos = Shop::query()->where('id', $discount->shopId)->pluck('latPos')->first();

            $distanceObject = new Distance($data['latPos'], $data['logPos']);
            $distance = $distanceObject->calculateDistanceInMeters($shopLatPos, $shopLogPos);

            if ($distance <= $MaxDistance) {
                //ToDo : Find a way to remove this global reference
                \App\Http\Resources\Discounts::$distance[] = $distance;
                $requestedDiscounts->push($discount);
            }
        }

        return new DiscountsCollection($requestedDiscounts);

    }

    /**
     * @param Request $request
     * @return DiscountsCollection
     */
    public function TopList(Request $request)
    {
        $this->validate($request, [
            'logPos' => 'required|numeric',
            'latPos' => 'required|numeric'
        ]);

        // ToDo : Get and pass the city, for speed
        $discounts = DB::select("call getTopDiscounts(10)");
        $topList = collect();

        foreach ($discounts as $discount) {
            $shopLogPos = Shop::query()->where('id', $discount->shopId)->pluck('logPos')->first();
            $shopLatPos = Shop::query()->where('id', $discount->shopId)->pluck('latPos')->first();
            $distanceObject = new Distance(request('latPos'), request('logPos'));
            $distance = $distanceObject->calculateDistanceInMeters($shopLatPos, $shopLogPos);

            // ToDo : Get and pass the distance for discounts
            if ($distance <= 3000) {
                \App\Http\Resources\Discounts::$distance[] = $distance;
                $topList->push($discount);
            }
        }

        return new DiscountsCollection($topList);

    }

}
