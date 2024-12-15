<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RepairResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'kind_of_product' => $this->kind_of_product,
            'category' => $this->category,
            'brand' => $this->brand,
            'model_type_number' => $this->model_type_number,
            'year_of_production' => $this->year_of_production,
            'problem_description' => $this->problem_description,
            'defect_found' => $this->defect_found,
            'repair_action' => $this->repair_action,
            'repair_information_url' => $this->repair_information_url,
            'suggestions_for_other_repairers' => $this->suggestions_for_other_repairers,
        ];
    }
}
