<?php

namespace App\Traits;

use App\Transformers\DataCabangTransformers;

trait getDataCabang
{    
    
    public function DataCabang(){
        $cabang = [];
        $listCabang = [];

        // DummyData
        for ($i = 1; $i <= 60; $i++) {
            $cabang[] = (object)[
                "id" => $i,
                "cabang" =>"INDOMARCO ($i)",
            ];
        }
        $listCabang = DataCabangTransformers::collection($cabang);
        return $listCabang;
    }
}