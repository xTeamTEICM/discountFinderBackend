<?php

namespace App\Http\Controllers;

use App\Category;
use App\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DiscountController extends Controller
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function list()
    {
        return Discount::all();
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function get($id, Request $request)
    {
        $request['id'] = $id;

        $data = $this->validate($request, [
            'id' => 'required|numeric'
        ]);

        return Discount::find($data['id']);
    }

    /**
     * @param Request $request
     * @return Discount|\Illuminate\Http\JsonResponse
     * @throws \LaravelFCM\Message\InvalidOptionException
     */
    public function post(Request $request)
    {
        // Validate data
        $data = $this->validate($request, [
            'shopId' => 'required|numeric',
            'category' => 'required|numeric',
            'originalPrice' => 'required|numeric',
            'currentPrice' => 'required|numeric',
            'description' => 'required|string',
            'imageTitle' => 'required|string',
            'imageBase' => 'required|string'
        ]);

        // Save image
        $imageController = new ImageController();
        $imageResult = $imageController->save(
            $data['shopId'] . $data['imageTitle'],
            $data['imageBase'],
            public_path() . '/images/'
        );
        if ($imageResult == "Invalid data") {
            return response()->json(
                [
                    'message' => 'Invalid picture'
                ], 400
            );
        }

        // Create discount
        $discount = new Discount();
        $discount->shopId = $data['shopId'];
        $discount->category = $data['category'];
        $discount->originalPrice = $data['originalPrice'];
        $discount->currentPrice = $data['currentPrice'];
        $discount->description = $data['description'];
        $discount->image = config('app.url') . ':' . env('APP_PORT', 'default') . '/images/' . $imageResult;
        $discount->save();
        $discount->push();

        // Create notification string
        $msgCategory = Category::query()->where('id', '=', $data['category'])->first(['title'])['title'];
        $msgOldPrice = $data['originalPrice'];
        $msgCurrPrice = $data['currentPrice'];
        $msg = "Υπάρχει νέα προσφορά στην κατηγορία $msgCategory, από $msgOldPrice € μόνο $msgCurrPrice €, δείτε την τώρα !!!";

        // Find users to notify
        $tokensAsArray = DB::select("call getMatchedUsers(" . $data['category'] . "," . $data['currentPrice'] . ")");
        // Convert the default array to collection
        $tokensAsCollection = collect();
        $count = 0;
        foreach ($tokensAsArray as $token) {
            $tokensAsCollection->push($token->deviceToken);
            $count++;
        }
        // Check if we have users to notify, if we have sent notifications
        if ($count != 0) {
            $fcm = new FCMController();
            $fcm->sentToMultiple(
                $tokensAsCollection->toArray(),
                'Υπάρχει νέα προσφορά',
                $msg,
                [
                    'id' => $discount->id
                ],//data
                'postedNewDiscount'
            );
        }

        return $discount;
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse|null|static
     */
    public function put($id, Request $request)
    {
        $request['id'] = $id;

        $data = $this->validate($request, [
            'id' => 'required|numeric',
            'shopId' => 'required|numeric',
            'category' => 'required|numeric',
            'originalPrice' => 'required|numeric',
            'currentPrice' => 'required|numeric',
            'description' => 'required|string'
        ]);

        $discount = Discount::find($data['id']);

        if ($discount != null) {
            // ToDo : Check if the discount is from user's shops, if not return 401, Unauthorized
            $discount->category = $data['category'];
            $discount->originalPrice = $data['originalPrice'];
            $discount->currentPrice = $data['currentPrice'];
            $discount->description = $data['description'];

            $discount->save();
            $discount->push();
            return $discount;
        } else {
            return response()->json([
                'message' => 'Discount not found'
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

        $discount = Discount::find($data['id']);

        if ($discount != null) {
            // ToDo : Check if the discount is from user's shops, if not return 401, Unauthorized
            $discount->delete();
            return response()->json([], 200);
        } else {
            return response()->json([
                'message' => 'Discount not found'
            ], 404);
        }
    }


}
