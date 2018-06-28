<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "open_orders";
    public $timestamps = false;
    protected $fillable = ['created_at'];
}
