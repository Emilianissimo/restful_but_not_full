<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
    	'name',
    ];

    protected $hidden = [
    	'pivot',
    	'created_at',
    	'updated_at'
    ];

    public function products()
    {
    	return $this->belongsToMany(
    		Product::class,
    		'product__categories',
    		'category_id',
    		'product_id'
    	);
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
