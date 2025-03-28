<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['service_type', 'description'];

    public function serviceproviders(){
        return $this->belongsToMany(ServiceProvider::class,'service_service_provider')->withPivot('price');
    }
    public function orders(){
        return $this->belongsToMany(Order::class,'order_service')->withPivot('price');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
