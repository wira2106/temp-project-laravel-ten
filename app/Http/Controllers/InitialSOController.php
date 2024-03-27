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
        //     $this->DB_PGSQL->beginTransaction();

            
        //     $this->DB_PGSQL->commit();
        // } catch (\Throwable $th) {
            
        //     $this->DB_PGSQL->rollBack();
        //     dd($th);
        //     return response()->json(['errors'=>true,'messages'=>$th->getMessage()],500);
        // }
    }

    public function index(){
        return view('initial-so.page.index');
    }
    public function get_plu(){
        $data_master_produk = $this->DB_PGSQL->table("tbmaster_lokasi")
                                ->join("tbmaster_prodmast",function($join){
                                    $join->on("lks_prdcd" ,"=" ,"prd_prdcd");
                                })
                               ->selectRaw("
                                    lks_prdcd as prdcd
                               ")
                               ->distinct()
                               ->orderBy($this->DB_PGSQL->raw("lks_prdcd"))
                               ->get();
        return $data_master_produk;
    }
    public function get_rak(){
        $data_master_produk = $this->DB_PGSQL->table("tbmaster_lokasi")
                                ->join("tbmaster_prodmast",function($join){
                                    $join->on("lks_prdcd" ,"=" ,"prd_prdcd");
                                })
                               ->selectRaw("
                                    lks_prdcd as prdcd
                               ")
                               ->distinct()
                               ->orderBy($this->DB_PGSQL->raw("lks_prdcd"))
                               ->get();
        return $data_master_produk;
    }

    public function data_input(Request $request){

        if ($request->prdcd) {
                $response = $this->insert_temp_plu("prdcd",$request->prdcd);
                if ($response['errors']) {
                return response()->json($response,500);
                }
        } else {
                $response = $this->insert_temp_plu("rak",$request->rak);
                if ($response['errors']) {
                return response()->json($response,500);
                }
        }
       
        $data = $this->DB_PGSQL->table("tbtr_tempso")
                        ->selectRaw("
                            TEMP_PLU,
                            TEMP_RECORDID,
                            COALESCE(TEMP_SUBRAK, 'BYPLU') AS TEMP_SUBRAK,
                            PRD_PRDCD,
                            PRD_DESKRIPSIPANJANG,
                            PRD_UNIT || '/' || PRD_FRAC AS PRD_UNIT,
                            PRD_KODETAG 
                        ")
                        ->join("tbmaster_prodmast",function($join){
                            $join->on("temp_plu" ,"=" ,"prd_prdcd");
                        })
                        ->whereRaw("temp_recordid IS NULL ");
        if ($request->kategori == "fast moving") {
           $data = $data
                      ->whereRaw("PRD_KODETAG IN ('E','D','S','L')");
        } elseif ($request->kategori == "slow moving") {
           $data = $data
                      ->whereRaw("PRD_KODETAG NOT IN ('E','D','S','L')");
        } 
        
        $data = $data
                        ->orderBy($this->DB_PGSQL->raw("temp_subrak"))
                        ->get();

        return $data;
            

    }
    public function insert_temp_plu($tipe,$data){
        $data_insert = [];
        $koderak = "";
        $subrak = "";
        if ($tipe == "prdcd") {
            $check_data = $this->DB_PGSQL->table("tbtr_tempso")
                            ->join("tbmaster_prodmast",function($join){
                                $join->on("temp_plu" ,"=" ,"prd_prdcd");
                            })
                             ->whereRaw("temp_plu LIKE '%$data%'")
                             ->whereRaw("temp_recordid is null")
                             ->get();
                             
            $data = $this->DB_PGSQL->table("tbmaster_lokasi")
                    ->selectRaw("
                        LKS_PRDCD
                    ")
                    ->distinct()
                    ->whereRaw("LKS_PRDCD ='$data'")
                    ->get();

        } else {
            $check_data = $this->DB_PGSQL->table("tbtr_tempso")
                             ->whereRaw("temp_subrak LIKE '%$data%'")
                             ->whereRaw("temp_recordid is null")
                             ->get();
            if (count($check_data) > 0) {
                return  ['errors'=>true,'messages'=>"Kode Subrak Sudah Ada (".$data.")"];
            } else {
                    $koderak = explode(".", $data)[0];
                    $subrak = explode(".", $data)[1];
                    $dt = DB::select("SELECT DISTINCT LKS_PRDCD, LKS_KODERAK, LKS_KODESUBRAK  FROM TBMASTER_LOKASI WHERE LKS_KODERAK ='{$koderak}' AND LKS_KODESUBRAK='{$subrak}' AND LKS_PRDCD IS NOT NULL ");
                $data = $this->DB_PGSQL->table("tbmaster_lokasi")
                        ->selectRaw("
                            LKS_PRDCD, LKS_KODERAK, LKS_KODESUBRAK
                        ")
                        ->distinct()
                        ->whereRaw("LKS_KODERAK ='$koderak'")
                        ->whereRaw("LKS_KODESUBRAK ='$subrak'")
                        ->get();
            }
        }
        
        foreach ($data as $key => $row) {
            $data_insert[] = [
                "temp_recordid" =>null,
                "temp_plu" => $row->lks_prdcd,
                "temp_subrak" => $tipe == "prdcd"?'':$koderak.$subrak,
                "temp_create_by" => session('userid'),
                "temp_create_dt" => date('Y-m-d H:i:s'),
            ];
        }
        try {
            $this->DB_PGSQL->beginTransaction();
            $response = null;
            if(count($check_data) && $check_data[0]->temp_recordid){
                $response = ['errors'=>true,'messages'=>"Kode Plu Sudah Ada (".$data.")"];
            }elseif(!count($check_data)){
                $this->DB_PGSQL->table("tbtr_tempso")->insert($data_insert);
                $response = ['errors'=>false,'messages'=>"success"];
            }else{
                $response = ['errors'=>false,'messages'=>"success"];
            }
            $this->DB_PGSQL->commit();
            return $response;
        } catch (\Throwable $th) {
            
            $this->DB_PGSQL->rollBack();
            // dd($th);
            return ['errors'=>true,'messages'=>$th->getMessage()];
        }
        
        
        
            

    }
}
