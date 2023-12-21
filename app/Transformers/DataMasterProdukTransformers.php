<?php

namespace App\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class DataMasterProdukTransformers extends JsonResource
{
    public function toArray($request)
    {    
        return [
           "prdcd" => $this->prdcd,
           "deskripsi" => $this->deskripsi,
        ];
    }
}