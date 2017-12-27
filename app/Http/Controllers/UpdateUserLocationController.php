<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UpdateUserLocationController extends Controller
{

    public function get(Request $request)
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

        $user->logPos = $data['logPos'];
        $user->latPos = $data['latPos'];
        $user->save();
        $user->push();

        return response()->json([], 200);

    }
}
