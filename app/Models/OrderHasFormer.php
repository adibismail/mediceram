<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderHasFormer extends Model
{
    public $timestamps = false;
    
    protected $table = 'order_has_formers';

    protected $fillable = ['order_tbl_id', 'former_tbl_id'];
}
