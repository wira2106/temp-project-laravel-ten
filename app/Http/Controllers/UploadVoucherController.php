<?php

namespace App\Http\Controllers;

use App\Traits\LibraryCSV;
use Illuminate\Http\Request;
use DB;

class UploadVoucherController extends Controller
{
    use LibraryCSV;
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
        return view('upload-voucher.page.index');
    }

    public function insert(Request $request){
        // $this->validate($request, [
        //     'file' => 'file|mimes:csv', // CSV file validation
        // ]);

        if(!$request->file){
            return response()->json(['errors'=>true,'messages'=>"Data CSV is not found !"],422);
        }

        $list = $this->csv_to_array($request->file);
        $ipAddress = $request->getClientIp();
        
        try {
            $this->DB_PGSQL->beginTransaction();
            $TglServer = date('Y-m-d H:i:s');
            $UserID = session('userid');
            $data_pminsert = [];
            $data_tminsert = [];
            foreach ($list as $key => $value) {
                $data_pminsert [] = [
                    "pmv_recordid" => $value["PLUIDM"],
                    "pmv_ip" =>  $ipAddress,
                    "pmv_create_by" => session('userid'),
                    "pmv_create_dt" => $TglServer,
                ];  

                $data_tminsert [] = [
                    "tpmv_prdcd" => $value["PLUIDM"],
                    "tpmv_ip" =>  $ipAddress,
                    "tpmv_create_by" => $UserID,
                    "tpmv_create_dt" => $TglServer,
                ];               
            }

            $this->DB_PGSQL->table('temp_plu_materai_voucher')->insert($data_tminsert);
            $data_history_plu_materai_voucher = $this->DB_PGSQL
                                            ->table('plu_materai_voucher')
                                            ->selectRaw("
                                                pmv_recordid, 
                                                pmv_pluidm, 
                                                pmv_pluigr, 
                                                pmv_create_by, 
                                                pmv_create_dt, 
                                                '$UserID', 
                                                current_timestamp
                                            ");
            $insert_using_history_plu_materai_voucher = $this->DB_PGSQL
                                            ->table("history_plu_materai_voucher")
                                            ->insertUsing(["hpmv_recordid", "hpmv_pluidm", "hpmv_pluigr", "hpmv_create_by", "hpmv_create_dt", "hpmv_move_by", "hpmv_move_dt"],$data_history_plu_materai_voucher);
            
            $this->DB_PGSQL->table('plu_materai_voucher')->delete();
            $data_plu_materai_voucher = $this->DB_PGSQL
                                            ->table('temp_plu_materai_voucher')
                                            ->leftJoin("tbmaster_prodcrm",function($join)use($ipAddress){
                                                $join->on("prc_pluidm" ,"=" ,"tpmv_prdcd") 
                                                     ->on("tpmv_ip" ,"=" ,$this->DB_PGSQL->raw("'$ipAddress'"));
                                            })
                                            ->selectRaw("
                                                tpmv_prdcd as pluidm,
                                                prc_pluigr as pluigr,
                                                '$UserID', 
                                                current_timestamp 
                                            ");
            $insert_using_plu_materai_voucher = $this->DB_PGSQL
                                            ->table("plu_materai_voucher")
                                            ->insertUsing(["pmv_pluidm","pmv_pluigr","pmv_create_by","pmv_create_dt"],$data_plu_materai_voucher);
            
            $this->DB_PGSQL->commit();
            return response()->json(['errors'=>false,'messages'=>"UPLOAD VOUCHER.CSV SELESAI!!"],200);
        } catch (\Throwable $th) {
            
            $this->DB_PGSQL->rollBack();
            // dd($th);
            return response()->json(['errors'=>true,'messages'=>$th->getMessage()],500);
        }

    }
}
