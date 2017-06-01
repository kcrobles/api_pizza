<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *  Items
 */
class Item extends Model
{
    public function invoices()
    {
        return $this->belongsToMany('App\Models\Invoices', 'invoice_item');
    }

    public function provider()
    {
    	return $this->belongsTo('App\Models\Provider');
    }
}
