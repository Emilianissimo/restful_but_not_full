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
        
        return $this->sendResponse($products->toArray(), 'Продукты подгружены.');
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

        $product = Product::add($request->all());
        return $this->sendResponse($product->toArray(), 'Товар создана.');
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

    public function show(Product $product)
    {
        $product = Product::find($product);
        if (is_null($product)) {
            return $this->sendError('Товара не существует.');
        }
        return $this->sendResponse($product->toArray(), 'Товар получена');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

         if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $product = Product::findOrFail($id);
        $product->edit($request->all());
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
