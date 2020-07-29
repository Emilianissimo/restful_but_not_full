<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\BaseController as Controller;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return $this->sendResponse($categories->toArray(), 'Категории подгружены.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Ошибка.', $validator->errors());       
        }

        $category = Category::add(json_decode($request->all()));
        return $this->sendResponse($category->toArray(), 'Категория создана.');
    }

    public function show(Category $category)
    {
        $category = Category::find($category);
        if (is_null($category)) {
            return $this->sendError('Категории не существует.');
        }
        return $this->sendResponse($category->toArray(), 'Категория получена');
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

         if($validator->fails()){
            return $this->sendError('Ошибка.', $validator->errors());       
        }

        $category = Category::findOrFail($id);
        $category->edit(json_decode($request->all()));
        return $this->sendResponse($category->toArray(), 'Категория обновлена.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        if ($category->products()->exists()) {
            return $this->sendError($category->toArray(), 'Категория имеет товары и не может быть удалена.');
        }
        $category->remove();
        return $this->sendResponse($category->toArray(), 'Категория удалена.');
    }
}
