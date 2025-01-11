<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class CarService extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'photo',
        'about',
        'duration_in_hour',
        'price',
        'icon'
    ];
    public function storeServices()
    {
        return $this->hasMany(StoreService::class, 'car_service_id');
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
