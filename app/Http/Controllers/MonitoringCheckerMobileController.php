<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Maatwebsite\Excel\Excel;
class MonitoringCheckerMobileController extends Controller
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
        return view('monitoring.page.index');
    }
    public function tampil(Request $request){
        $tanggal = $request->periode;
        if ($request->filter == 'checker') {
            $sql_data = $this->DB_PGSQL
                             ->table("tbtr_checker_header as h")
                             ->join($this->DB_PGSQL->raw("tbtr_checker_detail as d "),function($join){
                                $join->on($this->DB_PGSQL->raw("to_char(h.transactiondate,'YYYYMMDD') || h.cashierid || h.cashierstation || h.transactionno") ,"=" ,"d.nostruk");
                              })
                             ->selectRaw("
                                COALESCE(CHECKERID,'BELUM CHECKER') as CHECKER, TRANSACTIONNO || CASHIERID as struk, 
                                CASE WHEN d.qtyorder <> d.qtyreal then 1 else 0 end selisih ,transactiondate::date
                             ")
                             ->whereRaw("DATE_TRUNC('day', TRANSACTIONDATE)::date = '$tanggal'::date")
                             ->orderBy("checkerid")
                             ->toSql();
            $data = $this->DB_PGSQL
                         ->table($this->DB_PGSQL->raw("($sql_data) as data"))
                         ->selectRaw("checker as id, count(distinct struk) as total,  sum(selisih) as selisih,transactiondate")
                         ->groupBy("checker","transactiondate")
                         ->orderBy("selisih","desc")
                         ->get();
                         
        } else {
            $sql_data = $this->DB_PGSQL
                             ->table("tbtr_checker_header as h")
                             ->join($this->DB_PGSQL->raw("tbtr_checker_detail as d "),function($join){
                                $join->on($this->DB_PGSQL->raw("to_char(h.transactiondate,'YYYYMMDD') || h.cashierid || h.cashierstation || h.transactionno") ,"=" ,"d.nostruk");
                              })
                             ->selectRaw("
                                CASHIERID as CASHIER, TRANSACTIONNO || CASHIERID as struk,
                                CASE WHEN d.qtyorder <> d.qtyreal then 1 else 0 end selisih,transactiondate::date
                             ")
                             ->whereRaw("DATE_TRUNC('day', TRANSACTIONDATE) = '$tanggal'")
                             ->orderBy("checkerid")
                             ->toSql();
            $data = $this->DB_PGSQL
                         ->table($this->DB_PGSQL->raw("($sql_data) as data"))
                         ->selectRaw("cashier as id, count(distinct struk) as total,  sum(selisih) as selisih ,transactiondate")
                         ->groupBy("cashier","transactiondate")
                         ->orderBy("selisih","desc")
                         ->get();
        }
        
        if ($data) {
                return response()->json(['errors'=>false,'messages'=>'Berhasil','data'=>$data],200);
        }else{
                return response()->json(['errors'=>true,'messages'=>'Tidak Ada Data'],500);

        }
        
    }
    public function tampil_diluar_struk(Request $request){
        $tanggal = $request->periode;
        $data = $this->DB_PGSQL
                        ->table("tbtr_item_checker")
                        ->selectRaw("
                            CHECKER_ID,
                            PRDCD AS KODEPLU,
                            NAMA_BARANG,
                            QTY,
                            TRANSACTIONDATE AS TGL_TRANS,
                            CASHIERID AS KASIR,
                            CASHIERSTATION AS STATION,
                            TRANSACTIONNO AS NO_TRANS,
                            MEMBERCODE AS KODE_MEMBER,
                            (SELECT CUS_NAMAMEMBER FROM TBMASTER_CUSTOMER WHERE CUS_KODEMEMBER = TBTR_ITEM_CHECKER.MEMBERCODE) AS NAMA_MEMBER
                        ")
                        ->whereRaw("transactiondate::date = '$tanggal'::date")
                        ->orderBy("transactiondate","desc")
                        ->get(); 
        if ($data) {
                return response()->json(['errors'=>false,'messages'=>'Berhasil','data'=>$data],200);
        }else{
                return response()->json(['errors'=>true,'messages'=>'Tidak Ada Data'],500);

        }
        
    }
    public function selected_struk(Request $request){
        $tanggal = $request->periode;
        $id = $request->id;
        if ($request->filter == 'checker') {
            $sql_data = $this->DB_PGSQL
                             ->table("tbtr_checker_header as h")
                             ->join($this->DB_PGSQL->raw("tbtr_checker_detail as d "),function($join){
                                $join->on($this->DB_PGSQL->raw("to_char(h.transactiondate, 'YYYYMMDD') || h.cashierid || h.cashierstation || h.transactionno") ,"=" ,"d.nostruk");
                              })
                             ->selectRaw("
                                TRANSACTIONNO as NOTRANS, CASHIERID as KASIR, CASHIERSTATION as STATION,
                                MEMBERCODE MEMBER, TO_CHAR(CHECKERDATE, 'HH24:MI:SS') JAM,
                                CASE FLAG WHEN 'N' THEN 'BARU' WHEN 'C' THEN 'PROSES' WHEN 'Y' THEN 'SELESAI' WHEN 'P' THEN 'PENDING' END STATUS,
                                CASE WHEN d.qtyorder <> d.qtyreal THEN 1 ELSE 0 END selisih
                             ")
                             ->whereRaw("DATE_TRUNC('day', TRANSACTIONDATE)::date = '$tanggal'::date")
                             ->whereRaw("checkerid = '$id'")
                             ->orderBy("checkerdate")
                             ->toSql();
            $data = $this->DB_PGSQL
                         ->table($this->DB_PGSQL->raw("($sql_data) as data"))
                         ->selectRaw("NOTRANS, KASIR, STATION, MEMBER, JAM, STATUS, CASE WHEN SUM(selisih) > 0 THEN 1 ELSE 0 END selisih")
                         ->groupBy("notrans", "kasir", "station", "member", "jam", "status")
                         ->orderBy($this->DB_PGSQL->raw("7"),"desc")
                         ->get();
                         
        } else {
             $sql_data = $this->DB_PGSQL
                             ->table("tbtr_checker_header as h")
                             ->join($this->DB_PGSQL->raw("tbtr_checker_detail as d "),function($join){
                                $join->on($this->DB_PGSQL->raw("to_char(h.transactiondate, 'YYYYMMDD') || h.cashierid || h.cashierstation || h.transactionno") ,"=" ,"d.nostruk");
                              })
                             ->selectRaw("
                                TRANSACTIONNO as NOTRANS, CASHIERID as KASIR, CASHIERSTATION as STATION,
                                MEMBERCODE MEMBER, TO_CHAR(CHECKERDATE, 'HH24:MI:SS') as JAM,
                                CASE FLAG WHEN 'N' THEN 'BARU' WHEN 'C' THEN 'PROSES' WHEN 'Y' THEN 'SELESAI' WHEN 'P' THEN 'PENDING' END as STATUS,
                                CASE WHEN d.qtyorder <> d.qtyreal THEN 1 ELSE 0 END as selisih
                             ")
                             ->whereRaw("DATE_TRUNC('day', TRANSACTIONDATE)::date = '$tanggal'::date")
                             ->whereRaw("cashierid = '$id'")
                             ->orderBy("checkerdate")
                             ->toSql();
            $data = $this->DB_PGSQL
                         ->table($this->DB_PGSQL->raw("($sql_data) as data"))
                         ->selectRaw("NOTRANS, KASIR, STATION, MEMBER, JAM, STATUS, CASE WHEN SUM(selisih) > 0 THEN 1 ELSE 0 END selisih")
                         ->groupBy("notrans", "kasir", "station", "member", "jam", "status")
                         ->orderBy($this->DB_PGSQL->raw("7"),"desc")
                         ->get();
        }
        
        if ($data) {
                return response()->json(['errors'=>false,'messages'=>'Berhasil','data'=>$data],200);
        }else{
                return response()->json(['errors'=>true,'messages'=>'Tidak Ada Data'],500);

        }
        
    }
    public function selected_dv1(Request $request){
        $tanggal = $request->periode;
        $id = $request->id;
        $membercode = $request->member;
        $transactionno = $request->notrans;
        $cashierid = $request->kasir;
        $cashierstation = $request->station;

        // dd($id,$membercode,$transactionno,$cashierid,$cashierstation);
        if ($request->filter == 'checker') {
            $sql_data = $this->DB_PGSQL
                             ->table("tbtr_checker_header as h")
                             ->join($this->DB_PGSQL->raw("tbtr_checker_detail as d"),function($join){
                                $join->on($this->DB_PGSQL->raw("to_char(h.transactiondate, 'YYYYMMDD') || h.cashierid || h.cashierstation || h.transactionno") ,"=" ,"d.nostruk");
                              })
                             ->join($this->DB_PGSQL->raw("tbmaster_prodmast as p"),function($join){
                                $join->on("d.kodeplu","=" ,"p.prd_prdcd");
                              })
                             ->selectRaw("
                                            d.kodeplu AS PLU, p.prd_deskripsipanjang AS DESKRIPSI, 
                                             p.prd_unit AS UNIT, p.prd_frac AS FRAC, 
                                             d.qtyorder AS QTY_ORDER, d.qtyreal AS QTY_REAL, ABS(d.qtyorder-d.qtyreal) AS SELISIH, 
                                             d.keterangan AS KETERANGAN, d.referensi AS REFERENSI 
                             ")
                             ->whereRaw("checkerid = '$id'")
                             ->whereRaw("membercode = '$membercode'")
                             ->whereRaw("transactionno = '$transactionno'")
                             ->whereRaw("cashierid = '$cashierid'")
                             ->whereRaw("cashierstation = '$cashierstation'")
                             ->orderBy($this->DB_PGSQL->raw("7"),"desc")
                             ->toSql();
            $data = $this->DB_PGSQL
                         ->table($this->DB_PGSQL->raw("($sql_data) as b"))
                         ->selectRaw("ROW_NUMBER() OVER(), b.*")
                         ->orderBy($this->DB_PGSQL->raw("8"),"desc")
                         ->get();
                         
        } else {
                  $sql_data = $this->DB_PGSQL
                             ->table("tbtr_checker_header as h")
                             ->join($this->DB_PGSQL->raw("tbtr_checker_detail as d"),function($join){
                                $join->on($this->DB_PGSQL->raw("to_char(h.transactiondate, 'YYYYMMDD') || h.cashierid || h.cashierstation || h.transactionno") ,"=" ,"d.nostruk");
                              })
                             ->join($this->DB_PGSQL->raw("tbmaster_prodmast as p"),function($join){
                                $join->on("d.kodeplu","=" ,"p.prd_prdcd");
                              })
                             ->selectRaw("
                                            d.kodeplu AS PLU, p.prd_deskripsipanjang AS DESKRIPSI, 
                                             p.prd_unit AS UNIT, p.prd_frac AS FRAC, 
                                             d.qtyorder AS QTY_ORDER, d.qtyreal AS QTY_REAL, ABS(d.qtyorder-d.qtyreal) AS SELISIH, 
                                             d.keterangan AS KETERANGAN, d.referensi AS REFERENSI 
                             ")
                             ->whereRaw("membercode = '$membercode'")
                             ->whereRaw("transactionno = '$transactionno'")
                             ->whereRaw("cashierid = '$cashierid'")
                             ->whereRaw("cashierstation = '$cashierstation'")
                             ->orderBy($this->DB_PGSQL->raw("7"),"desc")
                             ->toSql();
            $data = $this->DB_PGSQL
                         ->table($this->DB_PGSQL->raw("($sql_data) as b"))
                         ->selectRaw("ROW_NUMBER() OVER(), b.*")
                         ->orderBy($this->DB_PGSQL->raw("8"),"desc")
                         ->get();
        }
        
        if ($data) {
                return response()->json(['errors'=>false,'messages'=>'Berhasil','data'=>$data],200);
        }else{
                return response()->json(['errors'=>true,'messages'=>'Tidak Ada Data'],500);

        }
        
    }
}
