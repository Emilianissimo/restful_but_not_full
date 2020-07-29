<?php

namespace App\Http\Controllers\Admin;

use App\Property;
use App\Http\Controllers\BaseController as Controller;
use Illuminate\Http\Request;

class PropertiesController extends Controller
{
    public function index()
    {
        $properties = Property::all();
        return $this->sendResponse($properties->makeHidden('price')->toArray(), 'Свойства подгружены.');
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

        $property = Property::add(json_decode($request->all()));
        return $this->sendResponse($property->makeHidden('price')->toArray(), 'Свойство создано.');
    }

    public function show(Property $property)
    {
        $property = Property::find($property);
        if (is_null($property)) {
            return $this->sendError('Свойства не существует.');
        }
        return $this->sendResponse($category->makeHidden('price')->toArray(), 'Свойство получено');
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

         if($validator->fails()){
            return $this->sendError('Ошибка.', $validator->errors());       
        }

        $property = Property::findOrFail($id);
        $property->edit(json_decode($request->all()));
        return $this->sendResponse($property->makeHidden('price')->toArray(), 'Свойство обновлено.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $property = Property::findOrFail($id);
        $property->remove();
        return $this->sendResponse($property->makeHidden('price')->toArray(), 'Свойство удалено.');
    }
}
