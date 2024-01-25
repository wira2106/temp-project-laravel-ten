<?php

namespace App\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class DataSuboutletTransformers extends JsonResource
{
    public function toArray($request)
    {    
        return [
           "id" => $this->sub_kodesuboutlet,
           "suboutlet" => $this->sub_kodesuboutlet."-".$this->sub_namasuboutlet,
           "sub_kodeigr"=>$this->sub_kodeigr,
           "sub_recordid"=>$this->sub_recordid,
           "sub_kodeoutlet"=>$this->sub_kodeoutlet,
           "sub_kodesuboutlet"=>$this->sub_kodesuboutlet,
           "sub_namasuboutlet"=>$this->sub_namasuboutlet,
           "sub_create_by"=>$this->sub_create_by,
           "sub_create_dt"=>$this->sub_create_dt,
           "sub_modify_by"=>$this->sub_modify_by,
           "sub_modify_dt"=>$this->sub_modify_dt,


        ];
    }
}