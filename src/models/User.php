<?php

namespace Yousef\SearchEngine\models;

use Yousef\SearchEngine\Searchable;

class User extends \Illuminate\Database\Eloquent\Model
{
    use Searchable;
    protected $table = 'user';
    protected $primaryKey = 'user_id';
}