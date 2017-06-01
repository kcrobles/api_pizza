<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *  Invoices
 */
class Invoice extends Model
{
	public function items()
	{
		return $this->belongsToMany('App\Models\Item', 'invoice_item');
	}

	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}

	public function customer()
	{
		return $this->belongsTo('App\Models\Customer');	
	}
}
