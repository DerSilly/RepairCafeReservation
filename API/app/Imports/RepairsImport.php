<?php

namespace App\Imports;

use App\Models\Repairs;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;

class RepairsImport implements ToModel, WithChunkReading, WithBatchInserts, SkipsEmptyRows
{
    use Importable;

    private $table;

    public function __construct($table)
    {
        $this->table = $table;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $result = new Repairs([
            'repair_id' => $row[0],
            'repair_date' => $row[1],
            'repair_cafe_number' => $row[2],
            'repair_cafe_name' => $row[3],
            'country' => $row[4],
            'kind_of_product' => $row[5],
            'category' => $row[6],
            'brand' => $row[7],
            'model_type_number' => $row[8],
            'year_of_production' => $row[9],
            'problem_description' => $row[10],
            'defect_found' => $row[11],
            'has_been_repaired' => $row[12],
            'repair_action' => $row[13],
            'half_repair_action' => $row[14],
            'not_repaired_reason_list' => $row[15],
            'not_repaired_reason_open' => $row[16],
            'reparability' => $row[17],
            'used_repair_information' => $row[18],
            'repair_information_source' => $row[19],
            'repair_information_url' => $row[20],
            'suggestions_for_other_repairers' => $row[21],
        ]);

        $result->setTable($this->table);
        return $result;
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 500;
    }

    public function batchSize(): int
    {
        return 500;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            '*.0' => 'required|integer',
            '*.1' => 'required|date',
            '*.2' => 'required|string|max:255',
            '*.3' => 'required|string|max:255',
            '*.4' => 'required|string|max:255',
            '*.5' => 'required|string|max:255',
            '*.6' => 'required|string|max:255',
            '*.7' => 'nullable|string|max:255',
            '*.8' => 'nullable|string|max:255',
            '*.9' => 'nullable|integer',
            '*.10' => 'nullable|string',
            '*.11' => 'nullable|string',
            '*.12' => 'required|boolean',
            '*.13' => 'nullable|string',
            '*.14' => 'nullable|string',
            '*.15' => 'nullable|string',
            '*.16' => 'nullable|string',
            '*.17' => 'nullable|integer',
            '*.18' => 'nullable|string',
            '*.19' => 'nullable|string',
            '*.20' => 'nullable|url',
            '*.21' => 'nullable|string',
        ];
    }

    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            '*.0.required' => 'The repair ID is required.',
            '*.1.required' => 'The repair date is required.',
            '*.2.required' => 'The repair cafe number is required.',
            '*.3.required' => 'The repair cafe name is required.',
            '*.4.required' => 'The country is required.',
            '*.5.required' => 'The kind of product is required.',
            '*.6.required' => 'The category is required.',
            '*.12.required' => 'The has been repaired field is required.',
        ];
    }

    public function isEmptyWhen(array $row): bool
    {
        return $row[0] === '';
    }
}
