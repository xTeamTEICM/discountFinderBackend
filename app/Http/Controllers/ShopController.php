<?php

namespace App\Http\Controllers;

use App\Discount;
use App\Shop;
use Illuminate\Http\Request;


class shopController extends Controller
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function list()
    {
        return Shop::all();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function myList()
    {
        $user = auth('api')->user();
        return Shop::query()->where("ownerId", "=", $user->id)->get();
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Http\JsonResponse|static[]
     */
    public function myDiscounts($id)
    {
        $request = new Request();
        $request['id'] = $id;

        $data = $this->validate($request, [
            'id' => 'required|numeric'
        ]);

        $shop = Shop::query()->where(
            'ownerId',
            '=',
            Auth()->user()->id
        )->find($data['id']);

        if ($shop) {
            return Discount::query()->where('shopId', '=', $shop->id)->get();
        } else {
            return response()->json([
                'message' => 'Shop not found'
            ], 404);
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return Shop::find($id);
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    public function myGet($id)
    {
        $user = auth('api')->user();
        return Shop::query()->where("ownerId", "=", $user->id)->find($id);
    }

    /**
     * @param Request $request
     * @return Shop
     */
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

        $shop->save();
        $shop->push();

        return $shop;

    }

    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    public function update($id, Request $request)
    {

        $request['id'] = $id;
        $data = $this->validate($request, [
            'id' => 'required|integer',
            'brandName' => 'required|string',
            'logPos' => 'required|numeric',
            'latPos' => 'required|numeric'
        ]);

        $user = auth('api')->user();
        $shop = Shop::find($data['id']);

        if ($shop) {
            if ($shop->ownerId == $user->id) {
                $shop->brandName = $data['brandName'];
                $shop->logPos = $data['logPos'];
                $shop->latPos = $data['latPos'];

                $shop->save();
                $shop->push();

                return $shop;
            } else {
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);
            }
        } else {
            return response()->json([
                'message' => 'Shop not found'
            ], 404);
        }

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id, Request $request)
    {
        $request['id'] = $id;
        $data = $this->validate($request, [
            'id' => 'required|numeric'
        ]);

        $user = auth('api')->user();
        $shop = Shop::find($data['id']);

        if ($shop) {
            if ($shop->ownerId == $user->id) {
                $shop->delete();
                return response()->json([], 200);
            } else {
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);
            }
        } else {
            return response()->json([
                'message' => 'Shop not found'
            ], 404);
        }


    }
}
