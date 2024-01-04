<?php

namespace App\Http\Controllers;

use App\Traits\getDataCabang;
use App\Transformers\DataSMSTransformers;
use Illuminate\Http\Request;
use Faker\Factory as Faker;

class SMSController extends Controller
{
    use getDataCabang;
    public function view(Request $request){
        // dd($request->all());
        $data_sms = [];
        $page_start = 1;
        $page_end = $request->page*10;

        if($request->page > 1){
            $page_start = $page_end - 9;
        }
        // DummyData
        $faker = Faker::create('id_ID');
        for ($i = $page_start; $i <= $page_end; $i++) {
            $kode_cabang = $i;
            $kode_member = 20097021070+$i;
            $awal_tgl = date('Y-m-d',strtotime('2009-01-01'));
            $akhir_tgl = date('Y-m-d',strtotime('2010-01-01'));
            $awal_tgl = $faker->randomElement([
                date('Y-m-d',strtotime('2009-01-01')),
                date('Y-m-d',strtotime('2009-02-01')),
                date('Y-m-d',strtotime('2009-03-01')),
                date('Y-m-d',strtotime('2009-04-01')),
            ]);
            $akhir_tgl = $faker->randomElement([
                date('Y-m-d',strtotime('2010-01-01')),
                date('Y-m-d',strtotime('2010-02-01')),
                date('Y-m-d',strtotime('2010-03-01')),
                date('Y-m-d',strtotime('2010-04-01')),
            ]);
            
            $data_sms[] = (object)[
                "kode_cabang" => $kode_cabang,
                "cabang" => $kode_cabang." - INDOMARCO ($kode_cabang)",
                "kode" => $kode_member,
                "awal_tgl" => $awal_tgl,
                "akhir_tgl" => $akhir_tgl,
                "nama_sms" => "Harga Hemat Tgl ".date('d',strtotime($awal_tgl)),
                
            ];

        }

        return DataSMSTransformers::collection($data_sms)->additional([
            "dataCabang" => $this->DataCabang()
        ]);

    }

}
