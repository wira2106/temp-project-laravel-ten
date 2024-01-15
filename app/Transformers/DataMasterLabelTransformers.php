<?php

namespace App\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class DataMasterLabelTransformers extends JsonResource
{
    public function toArray($request)
    {    
        return [
            "ipadd" => $this->ipadd,
            "prdcd" => $this->prdcd,
            "kplu" => $this->kplu,
            "nama1" => $this->nama1,
            "nama2" => $this->nama2,
            "barc" => $this->barc,
            "jml1" => $this->jml1,
            "jml2" => $this->jml2,
            "jml3" => $this->jml3,
            "unit1" => $this->unit1,
            "unit2" => $this->unit2,
            "unit3" => $this->unit3,
            "price_all1" => $this->price_all1,
            "price_all2" => $this->price_all2,
            "price_all3" => $this->price_all3,
            "price_unit1" => $this->price_unit1,
            "price_unit2" => $this->price_unit2,
            "price_unit3" => $this->price_unit3,
            "fmbsts" => $this->fmbsts,
            "flag" => $this->flag,
            "lokasi" => $this->lokasi,
            "fmkdsb" => $this->fmkdsb,
            "statusppn" => $this->statusppn,
            "tempo" => $this->tempo,
            "tempo1" => $this->tempo1,
            "tglinsert" => $this->tglinsert,
            "lrec" => $this->lrec,
            "div" => $this->div,
            "dept" => $this->dept,
            "katb" => $this->katb
        ];
    }
}