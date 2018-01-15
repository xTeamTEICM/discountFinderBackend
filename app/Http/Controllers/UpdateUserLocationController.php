<?php

namespace App\Http\Controllers;

use App\CustomClasses\CoordinatesValidator;
use Illuminate\Http\Request;
use LaravelFCM\Message\InvalidOptionException;

class UpdateUserLocationController extends Controller
{

    /**
     * @return mixed
     */
    public function get()
    {
        $user = auth()->user();
        $response['latPos'] = $user->latPos;
        $response['logPos'] = $user->logPos;
        return $response;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $user = auth('api')->user();

        $data = $this->validate($request, [
            'logPos' => 'required|numeric',
            'latPos' => 'required|numeric'
        ]);

        if (!CoordinatesValidator::isValid($data['latPos'], $data['logPos'])) {
            return response()->json([
                'message' => "Invalid logPos and/or latPos"
            ], 422);
        }

        $geocoder = new GeocoderController($data['latPos'], $data['logPos'], 'el');

        $user->logPos = $data['logPos'];
        $user->latPos = $data['latPos'];
        $user->city = $geocoder->getCity();
        $user->save();
        $user->push();

        $findDiscounts = new FindDiscountsController();
        $response = $findDiscounts->list(500, $request);

        $count = 0;
        foreach ($response as $sample) {
            $count++;
        }

        if ($count == 1) {
            $fcm = new FCMController();

            $fcm->sentToOne($user->deviceToken,
                'Βρήκαμε 1 προσφορά κοντά σας',
                'Δείτε την τώρα !',
                [
                    'distance' => 500
                ],
                'discountNotification');

        } elseif ($count >= 2) {

            $fcm = new FCMController();

            $fcm->sentToOne($user->deviceToken,
                'Βρήκαμε ' . $count . ' προσφορές κοντά σας',
                'Δείτε τις τώρα !',
                [
                    'distance' => 500
                ],
                'discountsNotification');

        }


        return response()->json([], 200);

    }
}
