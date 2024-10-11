<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repairs extends Model
{
    use HasFactory;
    protected $table = 'repairs';

    public function setTable($table)
    {
        $this->table = $table;
    }

    protected $fillable = [
        'id',
        'repair_id',
        'repair_date',
        'repair_cafe_number',
        'repair_cafe_name',
        'country',
        'kind_of_product',
        'category',
        'brand',
        'model_type_number',
        'year_of_production',
        'problem_description',
        'defect_found',
        'has_been_repaired',
        'repair_action',
        'half_repair_action',
        'not_repaired_reason_list',
        'not_repaired_reason_open',
        'reparability',
        'used_repair_information',
        'repair_information_source',
        'repair_information_url',
        'suggestions_for_other_repairers',
    ];
}
