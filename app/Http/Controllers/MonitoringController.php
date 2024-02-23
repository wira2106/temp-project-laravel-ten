<?php

namespace App\Http\Controllers;

use App\Traits\LibraryCSV;
use Illuminate\Http\Request;
use DB;

class MonitoringController extends Controller
{
    use LibraryCSV;
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
        return view('monitoring.bytoko.index');
    }
    public function index_byitem(){
        return view('monitoring.byitem.index');
    }

    public function load_periode_toko(Request $request){
        $periode =$this->DB_PGSQL
                ->table("alokasi_seasonal_omi")
                ->selectRaw(" 
                    aso_create_dt AS credt,
                    TO_CHAR(aso_tglawal, 'DD-MM-YYYY') AS awal,
                    TO_CHAR(aso_tglakhir, 'DD-MM-YYYY') AS akhir,
                    CONCAT(TO_CHAR(aso_tglawal, 'DD/MM/YYYY'), ' - ', TO_CHAR(aso_tglakhir, 'DD/MM/YYYY')) as periode
                ")
                ->orderBy("aso_create_dt","asc")
                ->first();
        $toko =$this->DB_PGSQL
                ->table("alokasi_seasonal_omi")
                ->selectRaw("
                    aso_kodetoko AS kode,
                    tko_namaomi AS nama
                ")
                ->leftJoin("tbmaster_tokoigr",function($join){
                    $join->on("tko_kodeomi" ,"=" ,"aso_kodetoko");
                  })
                ->whereRaw("aso_deskripsi IS NOT NULL")
                ->orderBy("aso_kodetoko","asc")
                ->get();

        if (count($toko)) {

            return response()->json(['errors'=>false,'messages'=>"berhasil",'toko' =>$toko,'periode'=>$periode],200);
        } else {

            return response()->json(['errors'=>true,'messages'=>"Data Toko Tidak tersedia !"],500);
        }

    }
    public function load_periode_plu(Request $request){
        $periode =$this->DB_PGSQL
                ->table("alokasi_seasonal_omi")
                ->selectRaw(" 
                    aso_create_dt AS credt,
                    TO_CHAR(aso_tglawal, 'DD-MM-YYYY') AS awal,
                    TO_CHAR(aso_tglakhir, 'DD-MM-YYYY') AS akhir,
                    CONCAT(TO_CHAR(aso_tglawal, 'DD/MM/YYYY'), ' - ', TO_CHAR(aso_tglakhir, 'DD/MM/YYYY')) as periode
                ")
                ->orderBy("aso_create_dt","asc")
                ->first();
        $toko =$this->DB_PGSQL
                ->table("alokasi_seasonal_omi")
                ->selectRaw("
                    aso_prdcd AS kode,
                    aso_deskripsi AS nama
                ")
                ->whereRaw("aso_deskripsi IS NOT NULL")
                ->orderBy("aso_kodetoko","asc")
                ->get();

        if (count($toko)) {

            return response()->json(['errors'=>false,'messages'=>"berhasil",'toko' =>$toko,'periode'=>$periode],200);
        } else {

            return response()->json(['errors'=>true,'messages'=>"Data Toko Tidak tersedia !"],500);
        }

    }
    public function load_data_by_toko(Request $request){
        $kdToko = $request->toko;
        $periode = explode("-", $request->periode);
        $awal = str_replace(" ","",$periode[0]);
        $awal = str_replace("/","-",$periode[0]);
        $akhir = str_replace(" ","",$periode[1]);
        $akhir = str_replace("/","-",$periode[1]);
        $tglAwal = date('Y-m-d',strtotime($awal));
        $tglAkhir = date('Y-m-d',strtotime($akhir));

        if ($request->toko) {
            $where = "aso_kodetoko = '".$request->toko."'";
        } else {
            $where = "aso_prdcd = '".$request->plu."'";
        }
        
        $toko = $request->toko;
        $omi = $request->omi;
        // $omi = $toko . " - " . $omi;
        $data =$this->DB_PGSQL
                    ->select("
                        WITH seasonal_omi AS (
                            SELECT 
                                aso_prdcd AS plu,
                                aso_deskripsi AS deskripsi,
                                SUM(aso_qtyo) AS alokasi,
                                SUM(COALESCE(pso_qtyr, 0)) AS pemenuhan
                            FROM alokasi_seasonal_omi
                            LEFT JOIN pb_seasonal_omi ON pso_kodeseasonal = aso_kodeseasonal
                                AND pso_kodetoko = aso_kodetoko
                                AND pso_prdcd = aso_prdcd
                                AND COALESCE(pso_tglsph, current_date + INTERVAL '1 DAY')
                                BETWEEN '$tglAwal'::date AND '$tglAkhir'::date
                            WHERE $where
                                AND aso_deskripsi IS NOT NULL
                            GROUP BY aso_prdcd, aso_deskripsi
                        )
                        SELECT 
                            plu,
                            deskripsi AS deskripsi,
                            alokasi AS qty_alokasi,
                            pemenuhan AS qty_pemenuhan,
                            ROUND((pemenuhan / alokasi) * 100, 2) AS persentase_pemenuhan,
                            (alokasi - pemenuhan) AS sisa
                        FROM seasonal_omi
                        ORDER BY plu ASC
                    ");

        if (count($data)) {

            return response()->json(['errors'=>false,'messages'=>"berhasil",'data' =>$data],200);
        } else {

            return response()->json(['errors'=>true,'messages'=>"Data Toko Tidak tersedia !"],500);
        }

    }
    

}