<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Degree extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       // return parent::toArray($request);
       return [
           'id' => $this->id,
           'degree_name' => $this->degree_name,
           'degree_description' => $this->degree_description,
           'degree_type' => $this->degree_type,
           'degree_code' => $this->degree_code,
           'department_id' => $this->department_id,
           'graduation_rate' => $this->graduation_rate,
           'job_demand' => $this->job_demand,
           'job_prospects' => $this->job_prospects,
           'keywords' => $this->keywords
       ];
    }


}
