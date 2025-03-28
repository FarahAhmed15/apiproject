<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable=['category_name','description','admin_id'];

    public function serviceproviders(){
        return $this->hasMany(ServiceProvider::class);
    }
    public function admin(){
        return $this->belongsTo(Admin::class);
    }
    public function services()
    {
        return $this->hasMany(Service::class, 'category_id');
    }
}
