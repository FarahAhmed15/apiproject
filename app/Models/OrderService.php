<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderService extends Model
{
    protected $fillable = [
        'service_id',
        'order_id',
        'service_provider_id',
        'price',
        'commission',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function serviceProvider()
    {
        return $this->belongsTo(ServiceProvider::class);
    }

    public function calculateCommission($percentage)
    {
        return ($this->price * $percentage) / 100;
    }
}
