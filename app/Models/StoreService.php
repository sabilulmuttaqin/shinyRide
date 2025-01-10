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
}
