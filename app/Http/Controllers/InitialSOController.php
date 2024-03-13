<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class InitialSOController extends Controller
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
        return view('initial-so.page.index');
    }
    public function get_plu(){
        $data_master_produk = $this->DB_PGSQL->table("tbmaster_lokasi")
                               ->selectRaw("
                                    lks_prdcd as prdcd
                               ")
                               ->distinct()
                               ->orderBy($this->DB_PGSQL->raw("lks_prdcd"))
                               ->get();
        return $data_master_produk;
    }
}
