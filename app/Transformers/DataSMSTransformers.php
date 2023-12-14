<?php

namespace App\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class DataSMSTransformers extends JsonResource
{
    public function toArray($request)
    {    
        return [
            "kode_cabang" => $this->kode_cabang,
            "cabang" => $this->cabang,
            "kode" => $this->kode,
            "awal_tgl" => $this->awal_tgl,
            "akhir_tgl" => $this->akhir_tgl,
            "nama_sms" => $this->nama_sms,
        ];
    }
}