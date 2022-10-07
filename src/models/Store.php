<?php

namespace Yousef\SearchEngine\models;

use Yousef\SearchEngine\Searchable;

class Store extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'purpletree_vendor_stores';

    protected $guarded = [];

    const STORE_TYPES = [
        'seller' => 'seller',
        'appointment booking' => 'appointment booking'
    ];
}