<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Appointment extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'guest_id',
        'staff_id',
        'device_id',
        'location_id',
        'start_time',
        'end_time',
        'note',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function devices()
    {
        return $this->belongsToMany(Device::class, 'appointment_device_assignments')->withTimestamps();
    }
}
