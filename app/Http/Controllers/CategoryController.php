<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;


class categoryController extends Controller
{

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function list()
    {
        return Category::all();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return Category::find($id);
    }

    /**
     * @param Request $request
     * @return Category
     */
    public function post(Request $request)
    {
        $data = $this->validate($request, [
            'title' => 'required|string|unique:category'
        ]);

        $category = new Category();
        $category->title = $data['title'];
        $category->save();
        $category->push();

        return $category;
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        $request['id'] = $id;
        $data = $this->validate($request, [
            'id' => 'required|numeric',
            'title' => 'required|string|unique:category'
        ]);

        $category = Category::find($id);

        if ($category != null) {
            $category->title = $data['title'];
            $category->save();
            $category->push();
            return $category;
        } else {
            return response()->json([
                'message' => "Category not found"
            ], 404);
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove($id, Request $request)
    {
        $request['id'] = $id;
        $data = $this->validate($request, [
            'id' => 'required|numeric'
        ]);

        $category = category::find($data['id']);
        if ($category != null) {
            $category->delete();
            return response()->json([], 200);
        } else {
            return response()->json([
                'message' => 'Category not found'
            ], 404);
        }
    }

}
