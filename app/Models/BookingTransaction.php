<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'phone_number', 'booking_trx_id', 'proof', 'is_paid', 'total_amount', 'car_store_id', 'car_service_id', 'started_at', 'time_at'];
}
