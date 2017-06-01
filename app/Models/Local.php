<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *  Locales
 */
class Local extends Model
{
	protected $table = 'locals';
	
    public function users()
    {
    	return $this->hasMany('App\Models\User');
    }
}
