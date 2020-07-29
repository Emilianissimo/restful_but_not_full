<?php

namespace App;

use App\Category;
use App\Property;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    //при создании товара стоит просто выбрать его Properties, после сохранить и назначить цену за каждый, после просто вывести {{$product->min_price}}-{{max($product->properties->price)}}
    protected $fillable = [
    	'name',
    	'min_price',
    	'is_published',
    	'is_deleted'
    ];

    public function categories()
    {
    	return $this->belongsToMany(
    		Category::class,
    		'product__categories',
    		'product_id',
    		'category_id'
    	);
    }

    public function properties()
    {
    	return $this->belongsToMany(
    		Property::class,
    		'product__properties',
    		'product_id',
    		'property_id'
    	)->withPivot('price');
    }

    public static function add($fields){
		$product = new self;

		$product->fill($fields);
		$product->save();

		return $product;
	}

	public function edit($fields)
	{
		$this->fill($fields);
		$this->save();
	}

	public function remove()
	{
		$this->is_deleted = true;
		$this->save();
		// $this->delete(); удаление ежжи
	}

	public function setPublish()
    {
        $this->is_published = true;
        $this->save();
    }

    public function setUnPublished()
    {
        $this->is_published = false;
        $this->save();
    }

    public function toggleStatus()
    {
        if ($this->is_published) {
            return $this->setUnPublished();
        }
        return $this->setPublish();
    }

	public function setCategories($ids)
	{
		if ($ids == null)
        {
            return;
        }

        $this->categories()->sync($ids);
	}

	public function setProperties($ids)
	{
		if ($ids == null)
        {
            return;
        }

        $this->properties()->sync($ids);
	}
}
