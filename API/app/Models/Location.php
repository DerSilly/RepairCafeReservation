<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'phone_number',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function manager()
    {
        return $this->hasOne(User::class);
    }

}
