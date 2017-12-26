<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class deviceTokenController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setDeviceToken(Request $request)
    {
        $data = $this->validate($request, [
            'deviceToken' => 'required|String',
        ]);

        $user = auth('api')->user();
        $user->deviceToken = $data['deviceToken'];
        $user->save();
        $user->push();

        return response()->json([], 200);
    }
}
