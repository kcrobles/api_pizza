<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *  Users
 */
class User extends Model
{
    protected $hidden = ['password'];
    
    public function invoices()
    {
    	return $this->hasMany('App\Models\Invoice');
    }
    
    public function role()
    {
    	return $this->belongsTo('App\Models\Role');
    }

    public function local()
    {
    	return $this->belongsTo('App\Models\Local');
    }
}
