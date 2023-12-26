<?php

namespace App\Http\Controllers;

use App\Transformers\DataMasterProdukTransformers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DB;

class LabelController extends Controller
{
    public $DB_PGSQL;
    public function __construct()
    { 
        $this->DB_PGSQL = DB::connection('pgsql');

        // try {
        //     $this->DBConnection->beginTransaction();

            
        //     $this->DBConnection->commit();
        // } catch (\Throwable $th) {
            
        //     $this->DBConnection->rollBack();
        //     dd($th);
        //     return response()->json(['errors'=>true,'messages'=>$th->getMessage()],500);
        // }
    }

    public function index(){
        return view('cetak-label-price-tag.label.index');
    }

    public function data_master(){

        $data_master_produk = $this->master_produk();
        return DataMasterProdukTransformers::collection($data_master_produk);

    }
    public function master_produk(){
        $data_master_produk = $this->DB_PGSQL->table("tbmaster_prodmast")
                               ->selectRaw("
                                    min(prd_prdcd) as prdcd, 
                                    prd_deskripsipanjang as deskripsi 
                               ")
                               ->groupBy("prd_deskripsipanjang")
                               ->orderBy($this->DB_PGSQL->raw("min(prd_prdcd)"))
                               ->get();
        return $data_master_produk;
    }

    public function cetak(){
        return view('template-print.print');
    }
}
