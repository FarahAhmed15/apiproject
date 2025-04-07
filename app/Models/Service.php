<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['service_type'];

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
    public function admin(){
        return $this->belongsTo(Admin::class);
    }
    public function orderServices()
    {
        return $this->hasMany(OrderService::class);
    }
}
