<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable=['required_date','order_date','user_id'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function services(){
        return $this->belongsToMany(Service::class,'order_service')->withPivot('price');
    }
}
