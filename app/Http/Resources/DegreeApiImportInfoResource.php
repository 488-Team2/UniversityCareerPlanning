<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DegreeApiImportInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'data_type' => $this->data_type,
            'data_label' => $this->data_label
        ];
    }
}
