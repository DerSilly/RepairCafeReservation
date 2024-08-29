<?php
// app/Models/RepairDetail.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'repairer_id',
        'device_id',
        'repair_date',
        'fault',
        'solution',
        'repairability',
        'repair_failed_reason',
        'advice',
        'repair_source',
        'hint',
    ];

    public function repairer()
    {
        return $this->belongsTo(User::class, 'repairer_id');
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
