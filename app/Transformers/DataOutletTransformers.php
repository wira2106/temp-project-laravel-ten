<?php

namespace App\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class DataOutletTransformers extends JsonResource
{
    public function toArray($request)
    {    
        return [
           "id" => $this->out_kodeoutlet,
           "outlet" => $this->out_kodeoutlet."-".$this->out_namaoutlet,
           "out_kodeigr" => $this->out_kodeigr,
           "out_recordid" => $this->out_recordid,
           "out_kodeoutlet" => $this->out_kodeoutlet,
           "out_namaoutlet" => $this->out_namaoutlet,
           "out_create_by" => $this->out_create_by,
           "out_create_dt" => $this->out_create_dt,
           "out_modify_by" => $this->out_modify_by,
           "out_modify_dt" => $this->out_modify_dt,


        ];
    }
}