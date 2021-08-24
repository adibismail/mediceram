<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public $timestamps = false;
	
	public $primaryKey = 'customer_tbl_id';
    
    protected $table = 'customers';

    protected $fillable = ['customer_id', 'status'];
}
