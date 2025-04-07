<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Admin extends Authenticatable
{
    use Notifiable;
    protected $fillable = ['name', 'email', 'password' , 'access_token'];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function categories(){
        return $this->hasMany(Category::class);
    }
    public function services(){
        return $this->hasMany(Service::class);
    }
    public function serviceproviders(){
        return $this->hasMany(ServiceProvider::class);
    }
    public function users(){
        return $this->hasMany(User::class);
    }
}
