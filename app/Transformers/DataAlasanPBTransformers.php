<?php

namespace App\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class DataAlasanPBTransformers extends JsonResource
{
    public function toArray($request)
    {    
        return [
           "alasan" => $this->ALASAN,
           "alasan_last" => $this->ALASAN,
           "create_dt" => $this->CREATE_DT,
           "modify_dt" => $this->MODIFY_DT,
        ];
    }
}