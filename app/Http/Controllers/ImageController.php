<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * @param Request $request
     * @return string
     */
    public function save(Request $request)
    {

        $data = $this->validate($request, [
            'title' => 'required|string',
            'content' => 'required|string'
        ]);

        $path = "./../public/images/" . $data['title'] . ".jpg";
        file_put_contents($path, base64_decode($data['content']));

        return "/images/" . $data['title'] . ".jpg";
    }
}
