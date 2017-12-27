<?php

namespace App\Http\Controllers;

use App\category;
use App\requestedDiscount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class requestedDiscountController extends Controller
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function list()
    {
        $userId = Auth::user()->id;
        $requestedDiscounts = requestedDiscount::query()->where('userId', '=', $userId)->get();

        foreach ($requestedDiscounts as $requestedDiscount) {
            $requestedDiscount['categoryTitle'] = Category::find($requestedDiscount['category'])['title'];
        }

        return $requestedDiscounts;
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function get($id, Request $request)
    {
        $request['id'] = $id;

        $data = $this->validate($request, [
            'id' => 'required|numeric'
        ]);

        $requestedDiscount = requestedDiscount::find($data['id']);

        if ($requestedDiscount != null) {
            // ToDo : Check if the requested discount is from user, if not return 401, Unauthorized
            $requestedDiscount['categoryTitle'] = Category::find($requestedDiscount['category'])['title'];
            return $requestedDiscount;
        } else {
            return response()->json([
                'message' => 'Requested discount not found'
            ], 404);
        }
    }

    /**
     * @param Request $request
     * @return requestedDiscount
     */
    public function post(Request $request)
    {
        $data = $this->validate($request, [
            'category' => 'required|numeric',
            'price' => 'required|numeric',
            'tags' => 'required|string'
        ]);

        $userId = Auth::user()->id;

        $requestedDiscount = new requestedDiscount();
        $requestedDiscount->userId = $userId;
        $requestedDiscount->category = $data['category'];
        $requestedDiscount->price = $data['price'];
        $requestedDiscount->tags = $data['tags'];

        $requestedDiscount->save();
        $requestedDiscount->push();

        return $requestedDiscount;
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Model|null|string|static
     */
    public function put($id, Request $request)
    {
        $request['id'] = $id;

        $data = $this->validate($request, [
            'id' => 'required|numeric',
            'category' => 'required|numeric',
            'price' => 'required|numeric',
            'tags' => 'required|string'
        ]);

        $requestedDiscount = requestedDiscount::find($data['id']);

        if ($requestedDiscount != null) {
            // ToDo : Check if the requested discount is from user, if not return 401, Unauthorized
            $requestedDiscount->category = $data['category'];
            $requestedDiscount->price = $data['price'];
            $requestedDiscount->tags = $data['tags'];

            $requestedDiscount->save();
            $requestedDiscount->push();
            return $requestedDiscount;
        } else {
            return response()->json([
                'message' => 'Requested discount not found'
            ], 404);
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id, Request $request)
    {
        $request['id'] = $id;

        $data = $this->validate($request, [
            'id' => 'required|numeric'
        ]);

        $requestedDiscount = requestedDiscount::find($data['id']);
        if ($requestedDiscount != null) {
            // ToDo : Check if the requested discount is from user, if not return 401, Unauthorized
            $requestedDiscount->delete();
            return response()->json([], 200);
        } else {
            return response()->json([
                'message' => 'Requested discount not found'
            ], 404);
        }
    }
}