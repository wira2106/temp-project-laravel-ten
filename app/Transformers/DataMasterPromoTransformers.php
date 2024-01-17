<?php

namespace App\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class DataMasterPromoTransformers extends JsonResource
{
    public function toArray($request)
    {    
        return [
            "brg_brutobox" => $this->brg_brutobox,
            "brg_brutoctn" => $this->brg_brutoctn,
            "brg_brutopcs" => $this->brg_brutopcs,
            "brg_create_by" => $this->brg_create_by,
            "brg_create_dt" => $this->brg_create_dt,
            "brg_flavor" => $this->brg_flavor,
            "brg_kemasan" => $this->brg_kemasan,
            "brg_kodeigr" => $this->brg_kodeigr,
            "brg_merk" => $this->brg_merk,
            "brg_modify_by" => $this->brg_modify_by,
            "brg_modify_dt" => $this->brg_modify_dt,
            "brg_nama" => $this->brg_nama,
            "brg_prdcd" => $this->brg_prdcd,
            "brg_singkatan" => $this->brg_singkatan,
            "brg_ukuran" => $this->brg_ukuran,
            "fmjual" => $this->fmjual,
            "prmd_tglakhir" => date("d-m-Y",strtotime($this->prmd_tglakhir)),
            "prmd_tglawal" => date("d-m-Y",strtotime($this->prmd_tglawal))
        ];
    }
}