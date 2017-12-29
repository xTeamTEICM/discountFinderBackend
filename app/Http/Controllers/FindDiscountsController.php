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
     * @param $distance
     * @param Request $request
     * @return DiscountsCollection
     */
    public function list($distance, Request $request)
    {
        $request['distanceInMeters'] = $distance;
        $request['logPos'] = auth()->user()->logPos;
        $request['latPos'] = auth()->user()->latPos;

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
     * @param $distance
     * @param Request $request
     * @return DiscountsCollection
     */
    public function TopList($distance, Request $request)
    {
        $request['distanceInMeters'] = $distance;
        $request['logPos'] = auth()->user()->logPos;
        $request['latPos'] = auth()->user()->latPos;

        $data = $this->validate($request, [
            'distanceInMeters' => 'required|numeric',
            'logPos' => 'required|numeric',
            'latPos' => 'required|numeric'
        ]);

        // ToDo : Get and pass the city, for speed
        $discounts = DB::select("call getTopDiscounts(10)");
        $topList = collect();

        foreach ($discounts as $discount) {
            $shopLogPos = Shop::query()->where('id', $discount->shopId)->pluck('logPos')->first();
            $shopLatPos = Shop::query()->where('id', $discount->shopId)->pluck('latPos')->first();
            $distanceObject = new Distance($data['latPos'], $data['logPos']);
            $distance = $distanceObject->calculateDistanceInMeters($shopLatPos, $shopLogPos);

            // ToDo : Get and pass the distance for discounts
            if ($distance <= $data['distanceInMeters']) {
                \App\Http\Resources\Discounts::$distance[] = $distance;
                $topList->push($discount);
            }
        }

        return new DiscountsCollection($topList);

    }

    /**
     * @param Request $request
     * @return DiscountsCollection
     */
    public function TopListCity(Request $request)
    {

        $user = auth()->user();
        $userCity = $user->city;

        $discounts = DB::select("call getTopDiscountsCity('$userCity',10)");
        $topList = collect();

        foreach ($discounts as $discount) {
            $shopLogPos = Shop::query()->where('id', $discount->shopId)->pluck('logPos')->first();
            $shopLatPos = Shop::query()->where('id', $discount->shopId)->pluck('latPos')->first();
            $distanceObject = new Distance($user->latPos, $user->logPos);
            $distance = $distanceObject->calculateDistanceInMeters($shopLatPos, $shopLogPos);

            \App\Http\Resources\Discounts::$distance[] = $distance;
            $topList->push($discount);
        }

        return new DiscountsCollection($topList);

    }

}
