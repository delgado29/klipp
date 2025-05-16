<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'employee_id',
        'business_id',
        'service_id',
        'date',
        'time',
        'status',
        'name',
        'phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
