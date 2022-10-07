<?php

namespace Yousef\SearchEngine\models;

use Yousef\SearchEngine\Searchable;

class Product extends \Illuminate\Database\Eloquent\Model
{
    use Searchable;
    protected $table = 'product';

    protected $primaryKey = 'product_id';

    protected $guarded = [];

    protected $hidden = ['pivot'];

    public function store()
    {
        return $this->belongsToMany(Store::class, 'product_to_vendor_store', 'product_id', 'vendor_store_id');
    }

    protected function makeAllSearchableUsing($query)
    {
        return $query->with('store');
    }

}