<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *  Provider
 */
class Provider extends Model
{
    public function items()
    {
    	return $this->hasMany('App\Models\Item');
    }
}
