<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreService extends Model
{
    protected $table = 'store_services';

    protected $fillable = [
        'car_store_id',
        'car_service_id'
    ];

    public function store()
    {
        return $this->belongsTo(CarStore::class, 'car_store_id');
    }

    public function service()
    {
        return $this->belongsTo(CarService::class, 'car_service_id');
    }
}
