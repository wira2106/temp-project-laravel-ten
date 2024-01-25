<?php

namespace App\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class DataJenisMemberTransformers extends JsonResource
{
    public function toArray($request)
    {    
        return [
           "id" => $this->jm_kode?$this->jm_kode:0,
           "jenis_member" => $this->jm_kode?$this->jm_keterangan:$this->jm_keterangan,
           "jm_kode" =>$this->jm_kode,
           "jm_keterangan" =>$this->jm_keterangan,
        ];
    }
}