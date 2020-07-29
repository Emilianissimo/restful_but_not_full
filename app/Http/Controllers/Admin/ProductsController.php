<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use App\Category;
use App\Property;
use App\Http\Controllers\BaseController as Controller;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::where('is_published', 1)
                            ->where('is_deleted', 0)
                            ->with('categories')
                            ->with('properties')
                            ->get();
        
        return $this->sendResponse($products->append('maxPrice')->toArray(), 'Продукты подгружены.');
    }

    public function create()
    {
        $categories = Category::all();
        $properties = Property::all();
        $response = [
            'success' => true,
            'data'    => ['categories'=>$categories, 'properties'=>$properties->makeHidden('price')],
            'message' => 'Создание продукта',
        ];
        return response()->json($response, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
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
            'name' => 'required',
            'min_price' => 'required',
            'categories' => 'array|min:2|max:10'
        ]);

        if($validator->fails()){
            return $this->sendError('Ошибка.', $validator->errors());       
        }

        $product = Product::add(json_decode($request->all()));
        $product->setCategories(json_decode($request->get('categories')));
        $product->setProperties(json_decode($request->get('properties')));
        $product->toggleStatus(json_decode($request->get('status')));
        return $this->sendResponse($product->toArray(), 'Товар создан.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $product = Product::where('is_published', 1)
                            ->where('is_deleted', 0)
                            ->with('categories')
                            ->with('properties')
                            ->find($id);
        if (is_null($product)) {
            return $this->sendError('Товара не существует.');
        }
        return $this->sendResponse($product->append('maxPrice')->toArray(), 'Товар получен');
    }

    public function edit($id)
    {
        $product = Product::where('is_published', 1)
                            ->where('is_deleted', 0)
                            ->with('categories')
                            ->with('properties')
                            ->find($id);
        $categories = Category::all();
        $properties = Property::all();
        $response = [
            'success' => true,
            'data'    => [
                'product'=>$product,
                'all_categories'=>$categories, 
                'all_properties'=>$properties->makeHidden('price')
            ],
            'message' => 'Создание продукта',
        ];
        return response()->json($response, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'min_price' => 'required',
            'categories' => 'array|min:2|max:10'
        ]);

         if($validator->fails()){
            return $this->sendError('Ошибка.', $validator->errors());       
        }

        $product = Product::findOrFail($id);
        $product->edit(json_decode($request->all()));
        $product->setCategories(json_decode($request->get('categories')));
        $product->setProperties(json_decode($request->get('properties')));
        $product->toggleStatus(json_decode($request->get('status')));
        return $this->sendResponse($product->toArray(), 'Товар обновлен.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::findOrFail($id)->remove();
        return $this->sendResponse($product->toArray(), 'Товар удален.');
    }

    public function addPriceToProperty(Request $request, $id, $property_id)
    {
        $product = Product::find($id);
        $property = $product->properties()->where('id', $property_id)->firstOrFail();
        $property->pivot->price = $request->get('price');
        $property->save();
        return $this->sendResponse($property->toArray(), 'Обновлена цена за тип продукта');
    }
}
