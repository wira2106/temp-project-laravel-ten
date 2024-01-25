<?php

namespace App\Traits;

use App\Transformers\DataCabangTransformers;

trait getDataCabang
{    
    $this->no_db = true;
    if(!( $this->no_db)){
        $this->DB_ORACLE = DB::connection('pgsql');
    }
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