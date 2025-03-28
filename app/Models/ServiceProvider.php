<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class ServiceProvider extends Authenticatable
{
    use Notifiable;
    protected $fillable = ['name', 'email', 'password', 'access_token' ,'experience_years' ,'category_id', 'admin_id'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function admin(){
        return $this->belongsTo(Admin::class);
    }
    public function services(){
        return $this->belongsToMany(Service::class,'service_service_provider')->withPivot('price');
    }
}
