<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
    	'name',
    ];

    public function products()
    {
    	return $this->belongsToMany(
    		Product::class,
    		'product__properties',
    		'property_id',
    		'product_id'
    	)->withPivot('price');
    }

    public static function add($fields){
		$category = new self;

		$category->fill($fields);
		$category->save();

		return $category;
	}

	public function edit($fields)
	{
		$this->fill($fields);
		$this->save();
	}

	public function remove()
	{
		$this->delete();
	}
}
