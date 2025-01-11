<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class CarStore extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'slug', 'rating', 'thumbnail', 'is_open', 'is_full', 'address', 'phone_number', 'cs_name', 'city_id'];

    public function storeServices()
    {
        return $this->hasMany(StoreService::class, 'car_store_id');
    }

    public function photos()
    {
        return $this->hasMany(StorePhoto::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function transactions()
    {
        return $this->hasMany(BookingTransaction::class);
    }
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
}
