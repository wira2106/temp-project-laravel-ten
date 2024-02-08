<?php

namespace App\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class DataZonaTransformers extends JsonResource
{
    public function toArray($request)
    {    
        return [
           "zona" => $this->zona,
           "toko" => $this->toko,
        ];
    }
}