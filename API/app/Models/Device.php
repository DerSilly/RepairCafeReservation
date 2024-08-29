<?php
// app/Models/Device.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'kind_product',
        'category',
        'brand',
        'product_build_year',
        'model',
        'cause_of_fault',
    ];

    public function repairDetail()
    {
        return $this->hasOne(RepairDetail::class);
    }

    public function appointment ()
    {
        return $this->belongsToMany(Appointment::class, 'appointment_device_assignments');
    }
}
