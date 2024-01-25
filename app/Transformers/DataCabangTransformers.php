<?php

namespace App\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class DataCabangTransformers extends JsonResource
{
    public function toArray($request)
    {    
        return [
           "id" => $this->cab_kodecabang,
           "cabang" => $this->cab_kodecabang."-".$this->cab_namacabang,
            "cab_kodeigr" =>$this->cab_kodeigr,
            "cab_recordid" =>$this->cab_recordid,
            "cab_kodecabang" =>$this->cab_kodecabang,
            "cab_kodewilayah" =>$this->cab_kodewilayah,
            "cab_namacabang" =>$this->cab_namacabang,
            "cab_singkatancabang" =>$this->cab_singkatancabang,
            "cab_alamat1" =>$this->cab_alamat1,
            "cab_alamat2" =>$this->cab_alamat2,
            "cab_alamat3" =>$this->cab_alamat3,
            "cab_teleponcabang" =>$this->cab_teleponcabang,
            "cab_faxcabang" =>$this->cab_faxcabang,
            "cab_npwpcabang" =>$this->cab_npwpcabang,
            "cab_nosk" =>$this->cab_nosk,
            "cab_tglsk" =>$this->cab_tglsk,
            "cab_alamatfakturpajak1" =>$this->cab_alamatfakturpajak1,
            "cab_alamatfakturpajak2" =>$this->cab_alamatfakturpajak2,
            "cab_alamatfakturpajak3" =>$this->cab_alamatfakturpajak3,
            "cab_tglbuka" =>$this->cab_tglbuka,
            "cab_classcabang" =>$this->cab_classcabang,
            "cab_tipehrg" =>$this->cab_tipehrg,
            "cab_nokpp" =>$this->cab_nokpp,
            "cab_flagtransaksi" =>$this->cab_flagtransaksi,
            "cab_emailfrom" =>$this->cab_emailfrom,
            "cab_emailto" =>$this->cab_emailto,
            "cab_emailcc1" =>$this->cab_emailcc1,
            "cab_emailcc2" =>$this->cab_emailcc2,
            "cab_useremail" =>$this->cab_useremail,
            "cab_pwdemail" =>$this->cab_pwdemail,
            "cab_create_by" =>$this->cab_create_by,
            "cab_create_dt" =>$this->cab_create_dt,
            "cab_modify_by" =>$this->cab_modify_by,
            "cab_modify_dt" =>$this->cab_modify_dt,
            "cab_dblink" =>$this->cab_dblink,
            "cab_singkatan" =>$this->cab_singkatan,
            "cab_panggilan" =>$this->cab_panggilan,
            "cab_lat" =>$this->cab_lat,
            "cab_lng" =>$this->cab_lng,


        ];
    }
}