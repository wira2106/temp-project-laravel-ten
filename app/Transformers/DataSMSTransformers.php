<?php

namespace App\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class DataSMSTransformers extends JsonResource
{
    public function toArray($request)
    {    
        return [
            "kode_cabang" => $this->sms_kodeigr,
            "cabang" => $this->cab_namacabang,
            "kode" => $this->sms_kodemonitoring,
            "awal_tgl" => $this->sms_tglakhir,
            "akhir_tgl" => $this->sms_tglawal,
            "nama_sms" => $this->sms_namasms,
            "cab_namacabang" => $this->cab_namacabang,
            "sms_kodeigr" => $this->sms_kodeigr,
            "sms_kodemonitoring" => $this->sms_kodemonitoring,
            "sms_namasms" => $this->sms_namasms,
            "sms_tglawal" => $this->sms_tglawal,
            "sms_tglakhir" => $this->sms_tglakhir,
        ];
    }
}