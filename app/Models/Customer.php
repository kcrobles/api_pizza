<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *  Customers
 */
class Customer extends Model
{
	protected $hidden = ['password'];
	
    public function invoices()
    {
    	return $this->hasMany('App\Models\Invoice');
    }
}