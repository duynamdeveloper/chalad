<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    protected $table = 'stock_move_reasons';
    protected $fillable = ['name','created_at','updated_at'];
}
