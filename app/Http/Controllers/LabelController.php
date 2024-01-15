<?php

namespace App\Http\Controllers;

use App\Traits\LibraryPDF;
use App\Transformers\DataMasterLabelTransformers;
use App\Transformers\DataMasterProdukTransformers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DB;
use Svg\Tag\Rect;

class LabelController extends Controller
{
    use LibraryPDF;
    public $DB_PGSQL;
    public $ip_address;
    public $dtKeluarPromo;
    public $dtKeluar;
    public $PRec = 1;
    public $dtabOra;
    public $flag;
    public $jml = [];
    public $price_all = [];
    public $price_unit  = [];
    public $jmlL = [];
    public $price_promo = [];
    public $unit = [];
    public $barc = [];
    public $LRec = 1;
        public function __construct(Request $request)
    { 
        $this->DB_PGSQL = DB::connection('pgsql');
        $this->get_ip_address($request);

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

    public function get_ip_address(Request $request){
        $ipAddress = $request->getClientIp();
        // Get the local IP address
        $hostName = gethostname();
        $ss = gethostbyname($hostName);

        $this->ip_address = str_replace('.', '', $ipAddress);
        // dd($ipAddress,$hostName,$ss, $this->ip_address);

    }
    public function data_master(){

        $data_master_produk = $this->master_produk();
        return DataMasterProdukTransformers::collection($data_master_produk);

    }
    public function data_master_label(Request $request){

        $data_master_label = $this->master_label($request);
        return DataMasterLabelTransformers::collection($data_master_label);

    }
    
    public function data_subrak(Request $request){


        $results = $this->DB_PGSQL
                        ->table("tbmaster_lokasi")
                        ->selectRaw("
                            lks_kodesubrak as fmsrak
                        ")
                        ->distinct()
                        ->whereRaw("LKS_KodeRak = '$request->rak'")
                        ->whereRaw("LKS_KodeRak NOT LIKE 'H%'")
                        ->whereRaw("(LKS_KodeRak LIKE 'R%' OR LKS_KodeRak LIKE 'O%')")
                        ->whereRaw("(SUBSTR(LKS_TipeRak, 1, 1) IN ('B', 'I', 'N') OR LKS_JenisRak IN ('D', 'N'))")
                        ->whereRaw("COALESCE(LKS_KodeRak, ' ') <> ' '")
                        ->orderBy("fmsrak","asc")
                        ->get();
        return $results ;

    }
    public function data_tiperak(Request $request){


        $results = $this->DB_PGSQL
                        ->table("tbmaster_lokasi")
                        ->selectRaw("
                            lks_tiperak AS fmtipe
                        ")
                        ->distinct()
                        ->whereRaw("LKS_KodeRak = '$request->rak'")
                        ->whereRaw("LKS_KodeSubRak = '$request->sub_rak'")
                        ->whereRaw("COALESCE(LKS_TipeRak, '?') <> '?'")
                        ->whereRaw("LKS_KodeRak NOT LIKE 'H%'")
                        ->whereRaw("(LKS_KodeRak LIKE 'R%' OR LKS_KodeRak LIKE 'O%')")
                        ->whereRaw("(SUBSTR(LKS_TipeRak, 1, 1) IN ('B', 'I', 'N') OR LKS_JenisRak IN ('D', 'N'))")
                        ->orderBy("fmtipe","asc")
                        ->get();
        return $results ;

    }
    public function data_shelvingrak(Request $request){


        $results = $this->DB_PGSQL
                        ->table("tbmaster_lokasi")
                        ->selectRaw("
                            lks_shelvingrak as fmselv
                        ")
                        ->distinct()
                        ->whereRaw("LKS_KodeRak = '$request->rak'")
                        ->whereRaw("LKS_KodeSubRak = '$request->sub_rak'")
                        ->whereRaw("LKS_TipeRak = '$request->tipe'")
                        ->whereRaw("COALESCE(LKS_ShelvingRak, ' ') <> ' '")
                        ->whereRaw("LKS_KodeRak NOT LIKE 'H%'")
                        ->whereRaw("(LKS_KodeRak LIKE 'R%' OR LKS_KodeRak LIKE 'O%')")
                        ->whereRaw("(SUBSTR(LKS_TipeRak, 1, 1) IN ('B', 'I', 'N') OR LKS_JenisRak IN ('D', 'N'))")
                        ->orderBy("fmselv","asc")
                        ->get();
        return $results ;

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
    public function master_label(Request $request){
        $data_master_label = $this->DB_PGSQL->table('tblabel_detail_master')
                            ->whereRaw("ipadd = '$this->ip_address'")
                            ->whereRaw("prdcd like '%$request->prdcd%'")
                            ->orderBy('tglinsert','desc')
                            ->get();


        return $data_master_label;
    }

    public function insert_to_database(Request $request){
            $this->validate($request, [
                'prdcd' => 'required',
                'satuan' => 'required',
                'qty' => 'required',
            ]);

            
            $this->cek_delete_data_label($request);

            try {
                $this->DB_PGSQL->beginTransaction();
                
                // $prdcd = str_pad((int)$request->prdcd + 10000000, 7, '0', STR_PAD_LEFT);
                // $prdcd = substr($prdcd, -6);
                $prdcd = $request->prdcd;
                $desc = $request->desc;
                $desc = str_replace('('.$prdcd.') - ',"",$desc);
                
                $dobel = (int)$request->qty > 1;
            
                // Assuming there's a function prosesPRDCD in Laravel to handle the logic
                $this->proses_prdcd($prdcd . '0', $desc, (int)$request->qty, 'Manual',$request->satuan);
                $this->DB_PGSQL->table('tblabel')->delete();
                $this->DB_PGSQL->table('tblabel_detail')->delete();
    
                // Select records from tbLabel_Detail_Master
                $dtabOra2 = $this->DB_PGSQL->table('tblabel_detail_master')
                                ->whereRaw("ipadd = '$this->ip_address'")
                                ->orderBy('tglinsert')
                                ->get();
                
    
                
                $this->DB_PGSQL->commit();
                if (count($dtabOra2)) {
                    return response()->json(['errors'=>false,'messages'=>'Data Berhasil di  Tambah','list_data' => $dtabOra2],200);
                } else {
                    return response()->json(['errors'=>false,'messages'=>'Data tidak  ditemukan','list_data' => $dtabOra2],404);
                }
                
                
            } catch (\Throwable $th) {
                
                $this->DB_PGSQL->rollBack();
                // dd($th);
                return response()->json(['errors'=>true,'messages'=>$th->getMessage()],500);
            }




    }

    public function insert_to_database_by_rak(Request $request){
        $this->validate($request, [
            'rak' => 'required',
            'sub_rak' => 'required',
            'tipe' => 'required',
            'selving1' => 'required',
            'selving2' => 'required',
        ]);

        try {
            $this->DB_PGSQL->beginTransaction();
            
            $results = $this->DB_PGSQL
                            ->table("tbmaster_lokasi")
                            ->selectRaw("
                                LKS_PRDCD, PRD_DeskripsiPanjang
                            ")
                            ->distinct()
                            ->leftJoin("tbmaster_prodmast",function($join){
                                $join->on("lks_prdcd" ,"=" ,"prd_prdcd");
                            })
                            ->whereRaw("LKS_KODERAK = '$request->rak'")
                            ->whereRaw("LKS_KodeSubRak = '$request->sub_rak'")
                            ->whereRaw("LKS_TipeRak = '$request->tipe'")
                            ->whereRaw("LKS_ShelvingRak BETWEEN '$request->selving1' AND '$request->selving2' ")
                            ->whereRaw("LKS_KodeRak NOT LIKE 'H%'")
                            ->whereRaw("(LKS_KodeRak LIKE 'R%' OR LKS_KodeRak LIKE 'O%')")
                            ->whereRaw("(SUBSTRING(LKS_TipeRak, 1, 1) IN ('B', 'I', 'N') OR LKS_JenisRak IN ('D', 'N'))")
                            ->get();
            
            // Process the results
            if (count($results) > 0) {
                $this->dtKeluar = "";
                foreach ($results as $j => $row) {

                    $this->proses_prdcd($row->lks_prdcd, $row->prd_deskripsipanjang, 1, "Manual");
                }

                // Select records from tbLabel_Detail_Master
                $dtabOra2 = $this->DB_PGSQL->table('tblabel_detail_master')
                                ->whereRaw("ipadd = '$this->ip_address'")
                                ->orderBy('tglinsert')
                                ->get();
                
    
                
                $this->DB_PGSQL->commit();
                if (count($dtabOra2)) {
                    return response()->json(['errors'=>false,'messages'=>'Data Berhasil di  Tambah','list_data' => $dtabOra2],200);
                } else {
                    return response()->json(['errors'=>false,'messages'=>'Data tidak  ditemukan','list_data' => $dtabOra2],404);
                }
                
            }
            
            $this->DB_PGSQL->commit();
        } catch (\Throwable $th) {
            
            $this->DB_PGSQL->rollBack();
            // dd($th);
            return response()->json(['errors'=>true,'messages'=>$th->getMessage()],500);
        }
        
    }

    public function proses_prdcd($prdcd=null,$desc = null, $jmlPrint = null, $tipe= null, $satuan = ["all"]){
        
        try {
            $this->DB_PGSQL->beginTransaction();


            $this->price_promo = [];
            $this->price_a = [];
            $this->price_all = [];
            $this->price_unit = [];
            $this->unit = [];
            $this->jmlL = [];
            $this->barc = [];
            for ($f = 0; $f < 4; $f++) {
                $this->price_promo[$f] = 0;
            }

            $this->flag = "";
            for ($i = 0; $i < 5; $i++) {
                $this->price_a[$i] = 0;
                $this->price_all[$i] = 0;
                $this->price_unit[$i] = 0;
                $this->unit[$i] = "";
                $this->jmlL[$i] = "";
                $this->barc[$i] = "";
            }

            $klik = false;
            $this->flag = "";

            /**
             * Check $tipe
             */

            // start check $tipe
            if ($tipe == "Manual") {
                
                $dtProd =  $this->DB_PGSQL
                                ->table("tbtr_promomd")
                                ->leftJoin("tbmaster_prodmast",function($join){
                                    $join->on("prd_prdcd" ,"=" ,"prmd_prdcd");
                                })
                                ->selectRaw("
                                    prd_prdcd as prdcd,
                                    coalesce(prd_kodetag,' ') as ptag,
                                    prd_unit as unit,
                                    prd_kodedivisi as div,
                                    prd_kodedepartement as dept,
                                    prd_kodekategoribarang as katb,
                                    prmd_hrgjual as fmjual,
                                    prd_hrgjual as price_a
                                ")
                                ->whereRaw("DATE_TRUNC('DAY', prmd_tglakhir)::date >= DATE_TRUNC('DAY', NOW())::date ")
                                ->whereRaw("DATE_TRUNC('DAY', prmd_tglawal)::date <= DATE_TRUNC('DAY', NOW())::date ")
                                // ->whereRaw("SUBSTR(PRMD_PRDCD,1,6)='" . substr($prdcd, 0, 6) . "'")
                                ->whereRaw("SUBSTR(PRMD_PRDCD,1,6)= SUBSTR('" .$prdcd. "',1,6)")
                                ->get();

                if (count($dtProd) == 0) {
                    if (empty($this->dtKeluarPromo)) {
                        $this->dtKeluarPromo = "* ". $desc . " (Tidak Terdaftar Di TBTR_PROMOMD)";
                    }
                } else {
                    $memUnit = "";
                    $memPRDCD = "";
                    $memDiv = "";
                    $memDept = "";
                    $memKatb = "";
                    $keluar = false;
            
                    foreach ($dtProd as $row) {
                        if (substr($row->prdcd, -1) == "1" && $row->fmjual >= $row->price_a) {
                            $keluar = true;
                            break;
                        }
            
                        if (substr($row->prdcd, -1) == "1" && !in_array(strtoupper(trim($row->ptag)), ['C', 'X', 'Q', 'Z'])) {
                            $memUnit = $row->unit;
                            $memPRDCD = $row->prdcd;
                            $memDiv = $row->div;
                            $memDept = $row->dept;
                            $memKatb = $row->katb;
                            break;
                        }
                    }
            
                    // Continue with the remaining loops and logic...
                    if ($keluar) {
                        // Handle case when $keluar is true
                        if (empty($this->dtKeluarPromo)) {
                            $this->dtKeluarPromo = "* ".$desc . " (PRMD_HRGJUAL >= PRD_HRGJUAL)";
                        } 
                    } elseif (empty($memUnit)) {
                        // Handle case when data in prodmast has tag 'C', 'Z', 'Q', 'X'
                        if (empty($this->dtKeluarPromo)) {
                            $this->dtKeluarPromo = "* ".$desc . " (PRMD_HRGJUAL >= PRD_HRGJUAL)";
                        }
                    } else {
                        // Handle case when data in prodmast doesn't have tag 'C', 'Z', 'Q', 'X'
                        $queryPromoData = $this->DB_PGSQL
                                        ->table('tbtr_promomd')
                                        ->selectRaw("
                                            SUBSTR(PRMD_PRDCD,1,6) As fmkode,  
                                            min(PRMD_HrgJual) As fmjual,  
                                            PRMD_TGLAwal As fmfrtg,  
                                            PRMD_TglAkhir As fmtotg  
                                        ")
                                        ->whereRaw("DATE_TRUNC('DAY', prmd_tglakhir)::date >= DATE_TRUNC('DAY', to_date('" .date('Y-m-d H:i:s'). "','YYYYMMDD'))::date ")
                                        ->whereRaw("DATE_TRUNC('DAY', prmd_tglawal)::date <= DATE_TRUNC('DAY', to_date('".date('Y-m-d H:i:s')."','YYYYMMDD'))::date ")
                                        ->whereRaw("prmd_prdcd = '$memPRDCD'")
                                        ->groupBy($this->DB_PGSQL->raw("substr(prmd_prdcd,1,6)"), 'prmd_tglawal', 'prmd_tglakhir')
                                        ->toSql();
                
                        $promoData = $this->DB_PGSQL
                                        ->table($this->DB_PGSQL->raw("(".$queryPromoData.") a"))
                                        ->join('tbmaster_barang as brg', $this->DB_PGSQL->raw("SUBSTR(a.fmkode,1,6)"), '=', $this->DB_PGSQL->raw("SUBSTR(BRG_PRDCD,1,6)"))
                                        ->select('brg.*', 'a.fmjual', 'a.fmfrtg', 'a.fmtotg')
                                        ->get();
                
                        if (count($promoData) > 0) {
                            // Handle the case when $promoData is not empty
                            $insert_spromo = [];
                            foreach ($promoData as $key => $data) {
                                $insert_spromo []= [
                                    'ipadd' => $this->ip_address,
                                    'prnumber' => 1,
                                    'tglinsert' => date('Y-m-d H:i:s'),
                                    'prdcd' => $data->brg_prdcd,
                                    'merk' => str_replace("'", "''", $data->brg_merk),
                                    'namaa' => str_replace("'", "''", $data->brg_nama),
                                    'namab' => str_replace("'", "''", $data->brg_flavor . " " . $data->brg_ukuran),
                                    'harga' => $data->fmjual,
                                    'keta' => date("Y-m-d H:i:s", strtotime($data->fmfrtg)),
                                    'ketb' => date("Y-m-d H:i:s", strtotime($data->fmtotg)),
                                    'unit' => $memUnit,
                                    'prec' => $this->PRec,
                                    'div' => $memDiv,
                                    'dept' => $memDept,
                                    'katb' => $memKatb
                                ];

                                $this->PRec += 1;
                            }
                            $this->DB_PGSQL->table('tb_spromo')
                                ->insert( $insert_spromo);
                        }
                
                    }

                
                }


                

            }
            // end check $tipe

            // First Query

            $fmkrak = 0;
            $fmsrak = 0;
            $fmtipe = 0;
            $fmselv = 0;
            $fmnour = 0;
            $fmface = 0;
            $fmtrdb = 0;
            $fmtrab = 0;
            $results = $this->DB_PGSQL
                            ->table("tbmaster_lokasi")
                            ->selectRaw("
                                lks_koderak as fmkrak,
                                lks_kodesubrak as fmsrak,
                                lks_tiperak as fmtipe,
                                lks_shelvingrak as fmselv,
                                lpad(lks_nourut::text, 2, '0') as fmnour,
                                lks_tirkirikanan as fmface,
                                lks_tirdepanbelakang as fmtrdb,
                                lks_tiratasbawah as fmtrab
                            ")
                            ->whereRaw("SUBSTR(LKS_PRDCD, 1, 6) = SUBSTR('$prdcd',1,6)")
                            ->whereRaw("SUBSTR(COALESCE(lks_koderak, '?'), 1, 1) NOT IN ('D', 'A', 'G')")
                            ->whereRaw("LKS_KodeRak NOT LIKE 'H%'")
                            ->whereRaw("(LKS_KodeRak LIKE 'R%' OR LKS_KodeRak LIKE 'O%')")
                            ->whereRaw("(SUBSTR(LKS_TipeRak, 1, 1) IN ('B', 'I', 'N') OR LKS_JenisRak IN ('D', 'N'))")
                            ->get();
            
            $this->dtabOra = $results;
            if (count($results) > 0) {
                foreach ($results as $key => $row) {
                    $fmkrak = $row->fmkrak ?? 0;
                    $fmsrak = $row->fmsrak ?? 0;
                    $fmtipe = $row->fmtipe ?? 0;
                    $fmselv = $row->fmselv ?? 0;
                    $fmnour = $row->fmnour ?? 0;
                    $fmface = $row->fmface ?? 0;
                    $fmtrdb = $row->fmtrdb ?? 0;
                    $fmtrab = $row->fmtrab ?? 0;
                }
            } 

            // Second Query
            $results = $this->DB_PGSQL
                            ->table("tbmaster_prodmast")
                            ->leftJoin("tbmaster_prodcrm",function($join){
                                $join->on("prd_prdcd" ,"=" ,"prc_pluigr");
                            })
                            ->selectRaw("
                                PRD_PRDCD AS PRDCD,
                                COALESCE(PRD_KodeTag, ' ') AS PTAG,
                                COALESCE(PRD_Flag_Aktivasi, ' ') AS AKTIF,
                                CASE
                                    WHEN TRIM(PRC_PLUIGR) IS NOT NULL THEN
                                        CASE
                                            WHEN TRIM(PRC_PLUIDM) IS NOT NULL THEN 'O/I'
                                            ELSE 'O'
                                        END
                                    ELSE
                                        CASE
                                            WHEN TRIM(PRC_PLUIDM) IS NOT NULL THEN 'I'
                                            ELSE ''
                                        END
                                END AS typeplu
                            ")
                            ->whereRaw(" PRD_PRDCD LIKE '" .substr($prdcd, 0, 6)."%'")
                            ->whereRaw(" COALESCE(prd_kodetag, '?') NOT IN ('N', 'Q', 'U', 'Z', 'X')")
                            ->get();
            
            $this->dtabOra = $results;
            if (count($results) > 0) {
                $desc .= " " . $results[0]->typeplu;
            }

            // Third Query
            $left_join = "
                        SELECT
                            brc_prdcd,
                            MAX(brc_barcode) as barc,
                            NULL as bar2
                        FROM tbMaster_Barcode
                        GROUP BY brc_prdcd
                        HAVING COUNT(brc_prdcd) = 1

                        UNION

                        SELECT
                            brc_prdcd,
                            MIN(brc_barcode) as barc,
                            MAX(brc_barcode) as bar2
                        FROM tbMaster_Barcode
                        GROUP BY brc_prdcd
                        HAVING COUNT(brc_prdcd) = 2
                    ";

            $fmkdsb = "";
            $div = "";
            $dept = "";
            $katb = "";
            $results = $this->DB_PGSQL
                            ->table("tbmaster_prodmast")
                            ->leftJoin("tbmaster_hargabeli",function($join){
                                $join->on("hgb_prdcd" ,"=" ,"prd_prdcd");
                            })
                            ->leftJoin($this->DB_PGSQL->raw("($left_join) as brc"),function($join){
                                $join->on("brc_prdcd" ,"=" ,"prd_prdcd");
                            })
                            ->selectRaw("
                                prd_prdcd as prdcd,
                                prd_plumcg as kplu,
                                brc.barc,
                                brc.bar2,
                                prd_deskripsipanjang as desc2,
                                prd_minjual as minj,
                                prd_frac as frac,
                                prd_unit as unit,
                                coalesce(prd_kodetag, ' ') as ptag,
                                coalesce(prd_flag_aktivasi, ' ') as aktif,
                                prd_flagbarcode1 as fmbsts,
                                prd_kategoritoko as kttk,
                                prd_kodecabang as kcab,
                                prd_hrgjual as price_a,
                                prd_flagbkp1 as pkp,
                                prd_flagbkp2 as pkp2,
                                prd_kodedivisi as div,
                                prd_kodedepartement as dept,
                                prd_kodekategoribarang as katb,
                                hgb_statusbarang as fmkdsb
                            ")
                            ->distinct()
                            ->whereRaw("SUBSTR(PRD_PRDCD, 1, 6) = SUBSTR('$prdcd', 1, 6)");
            
            $temp = null;
            foreach ($satuan as $key => $checkedItems) {
                if ($checkedItems == "all") {
                    $results = $results->whereRaw("COALESCE(prd_flag_aktivasi, '?') NOT IN ('C', 'X')"); 
                }elseif ((int)$checkedItems > 0 ) {
                    if ((count($satuan)-1) == $key ) {
                        $temp = $temp."'$checkedItems'";
                    } else {
                        $temp = $temp."'$checkedItems',";
                    }
                } 
            }
            if ($temp) {
                $results = $results->whereRaw("SUBSTR(prd_prdcd, -1, 1) IN ($temp)"); 
            }
            $results = $results->get();
            $this->dtabOra = $results;
            // try {
                // foreach ($results as $key => $result_data) {
                    $fmkdsb = $results[0]->fmkdsb ?? "";
                    $div = $results[0]->div ?? "";
                    $dept = $results[0]->dept ?? "";
                    $katb = $results[0]->katb ?? "";
                // }
                
            // } catch (Exception $ex) {
            //     // Handle the exception
            // }
            

            $jmlhs = 0;
            $prodID = "";
            $kplu = "";
            $pkp = "";
            $barcode = "";
            $fmbsts = null;

            if (count($results) !== 0) {
                $this->DB_PGSQL->table('tblabel')->insert([
                    "ipadd" => (string)$this->ip_address,
                    "prdcd" => (string)substr(trim($prdcd), 0, 6),
                    "nama" => str_replace("'", "''", trim($desc))

                ]);
            
                $count = count($results);

                // convert to array data
                $temp = [];
                foreach ($this->dtabOra as $key => $value) {
                    $temp[] = (array) $value;
                }
                $this->dtabOra = $temp;
                // end convert to array data
                
                foreach ($results as $i => $row) {
                    $row = (array)$row;
                    if (substr($row['prdcd'], -1) == '0') {
                        if ($row['ptag'] !== 'Z' && $row['ptag'] !== 'X' && $row['ptag'] !== 'C' && $row['ptag'] !== 'Q') {
                            if ($row['kttk'] === '' && $row['kcab'] === '') {
                                break;
                            } else {
                                $this->cek_price($i, $jmlhs);
                                $kplu = $row['kplu'];
                                $fmbsts = $row['fmbsts'];
                                $this->barc[$jmlhs] = trim($row['barc'] . ' ' . $row['bar2']);
                                if ($this->barc[$jmlhs] !== '') {
                                    if (is_numeric(str_replace(' ', '', $this->barc[$jmlhs]))) {
                                        $barcode = $this->barc[$jmlhs];
                                    }
                                }
                                $this->unit[$jmlhs] = $row['unit'];
                                if ($pkp === '') $pkp = $row['pkp'] . $row['pkp2'];
                                $prodID = (string)substr(trim($prdcd), 0, 7);
                                $jmlhs++;
                                break;
                            }
                        } else {
                            break;
                        }
                    }
                }

                // convert to object data
                $temp = [];
                foreach ($this->dtabOra as $key => $value) {
                    $temp[] = (object) $value;
                }
                $this->dtabOra = $temp;
                // end convert to object data
                  
            
                // Repeat the above loop structure for the other conditions...
            
                $barcode0 = "";
                $barcode1 = "";
                $barcode2 = "";
                $barcode3 = "";
            
                foreach ($this->dtabOra as $i => $row) {
                    $row = (array)$row;
                    if (substr($row['prdcd'], -1) === '1') {
                        $barcode1 = trim($row['barc'] . ' ' . $row['bar2']);
                    }
                    if (substr($row['prdcd'], -1) === '2') {
                        $barcode2 = trim($row['barc'] . ' ' . $row['bar2']);
                    }
                    if (substr($row['prdcd'], -1) === '3') {
                        $barcode3 = trim($row['barc'] . ' ' . $row['bar2']);
                    }
                    if (substr($row['prdcd'], -1) === '0') {
                        $barcode0 = trim($row['barc'] . ' ' . $row['bar2']);
                    }
                }
            
                if ($barcode1 !== '') {
                    $barcode = $barcode1;
                } elseif ($barcode2 !== '') {
                    $barcode = $barcode2;
                } elseif ($barcode3 !== '') {
                    $barcode = $barcode3;
                } else {
                    $barcode = $barcode0;
                }

            } 

            if ($jmlhs > 3) {
                $prodID = str_replace("0/", "", $prodID);
                for ($i = 0; $i < 3; $i++) {
                    $this->price_a[$i] = $this->price_a[$i + 1];
                    $this->price_unit[$i] = $this->price_unit[$i + 1];
                    $this->price_all[$i] = $this->price_all[$i + 1];
                    $this->jmlL[$i] = $this->jmlL[$i + 1];
                    $this->unit[$i] = $this->unit[$i + 1];
                }
            }

            $i = 4;
            while ($i > 0) {
                if ($this->price_all[$i] === $this->price_all[$i - 1] && $this->price_all[$i] !== 0 && $this->price_all[$i - 1] !== 0) {
                    $this->price_all[$i] = 0;
                    $this->price_a[$i] = 0;
                    $this->price_unit[$i] = 0;
                    $this->jmlL[$i] = "";
                    $this->unit[$i] = "";
                    if (strrpos($prodID, "/") !== false) {
                        $prodID = substr($prodID, 0, strrpos($prodID, "/") - 1);
                    }
                }
                $i = $i - 1;
            }

            if ($prodID === "") {
                if ($this->dtKeluar === "") {
                    $this->dtKeluar = "* "." - " . trim($desc);
                } else {
                    $this->dtKeluar = $this->dtKeluar . PHP_EOL . "* "." - " . trim($desc);
                }
            } else {
                $strdata_insert = [];
                $this->LRec = 1;
                for ($i = 0; $i < $jmlPrint; $i++) {
                        $strdata_insert [] = [
                                'ipadd' => $this->ip_address,
                                'prdcd' => isset($prodID) ? $prodID : null,
                                'kplu' => isset($kplu) ? $kplu : null,
                                'nama1' => strlen(trim(str_replace("'", "''", $desc))) <= 40 ? trim(str_replace("'", "''", $desc)) : ' ',
                                'nama2' => strlen(trim(str_replace("'", "''", $desc))) > 40 ? trim(str_replace("'", "''", $desc)) : '',
                                'barc' => isset($barcode) ? $barcode : null,
                                'jml1' => isset($this->jmlL[0]) ? $this->jmlL[0] : null,
                                'jml2' => isset($this->jmlL[1]) ? $this->jmlL[1] : null,
                                'jml3' => isset($this->jmlL[2]) ? $this->jmlL[2] : null,
                                'unit1' => isset($this->unit[0]) ? $this->unit[0] : null,
                                'unit2' => isset($this->unit[1]) ? $this->unit[1] : null,
                                'unit3' => isset($this->unit[2]) ? $this->unit[2] : null,
                                'price_all1' => $this->price_all[0] === 0 ? null : $this->price_all[0],
                                'price_all2' => $this->price_all[1] === 0 ? null : $this->price_all[1],
                                'price_all3' => $this->price_all[2] === 0 ? null : $this->price_all[2],
                                'price_unit1' => $this->price_unit[0] === 0 ? null : $this->price_unit[0],
                                'price_unit2' => $this->price_unit[1] === 0 ? null : $this->price_unit[1],
                                'price_unit3' => $this->price_unit[2] === 0 ? null : $this->price_unit[2],
                                'fmbsts' => isset($fmbsts) ? $fmbsts : null,
                                'flag' => '',
                                'lokasi' => str_replace("'", "", trim((isset($fmkrak) ? $fmkrak : null)) . '/' . trim((isset($fmsrak) ? $fmsrak : null)) . '/' . trim((isset($fmtipe) ? $fmtipe : null)) . '/' . trim((isset($fmselv) ? $fmselv : null)) . '/' . str_pad(trim((isset($fmnour) ? $fmnour : null)), 2, '0') . '/' . trim((isset($fmface) ? $fmface : null)) . '/' . trim((isset($fmtrdb) ? $fmtrdb : null)) . '/' . trim((isset($fmtrab) ? $fmtrab : null))),
                                'fmkdsb' => str_replace("'", "", (isset($fmkdsb) ? $fmkdsb : null)),
                                'statusppn' => isset($pkp) ? $pkp : null,
                                'tglinsert' => date('Y-m-d H:i:s'),
                                'lrec' => $this->LRec,
                                'div' => str_replace("'", "", (isset($div) ? $div : null)),
                                'dept' => str_replace("'", "", (isset($dept) ? $dept : null)),
                                'katb' => str_replace("'", "", (isset($katb) ? $katb : null)),
                            ];
            
                    $this->LRec++;
                }
                $this->DB_PGSQL->table('tblabel_detail_master')->insert($strdata_insert);
            }

            
            $this->DB_PGSQL->commit();
            return true;
        } catch (\Throwable $th) {
            
            $this->DB_PGSQL->rollBack();
            dd($th);
            return response()->json(['errors'=>true,'messages'=>$th->getMessage()],500);
        }


    }

    public function cek_price($x = null , $y = null) {
        // try {
            
            if ($this->dtabOra[$x]['frac'] >= $this->dtabOra[$x]['minj']) {
                $this->jml[$y] = $this->dtabOra[$x]['frac'];
                if ($this->flag !== "*") {
                    $this->price_all[$y] = $this->dtabOra[$x]['price_a'];
                }
            } elseif ($this->dtabOra[$x]['frac'] < $this->dtabOra[$x]['minj']) {
                $this->jml[$y] = $this->dtabOra[$x]['minj'];
                if ($this->flag !== "*") {
                    $this->price_all[$y] = $this->dtabOra[$x]['price_a'] * $this->dtabOra[$x]['minj'];
                }
            }
    
            if (trim($this->dtabOra[$x]['unit']) === "KG") {
                $this->price_all[$y] = $this->dtabOra[$x]['price_a'] * $this->jml[$y] / 1000;
                $this->price_unit[$y] = ($this->price_all[$y] / $this->jml[$y]) * 1000;
            } else {
                $this->price_unit[$y] = ($this->price_all[$y] / $this->jml[$y]) * 1;
            }
    
            $this->jmlL[$y] = "/" . $this->jml[$y];
        // } catch (Exception $ex) {
        //     // Handle the exception if needed
        // }
    }

    public function cek_delete_data_label(Request $request){
        $list_LRec = null;
        if (isset($request->qty)) {
            $max = (int)$request->qty;
            for ($i=1; $i<=$max; $i++) { 
                // dd($i);
                if ($max > $i) {
                    $list_LRec = $list_LRec.$i.",";
                } else {
                    $list_LRec = $list_LRec.$i;
                }
            }
        }
        // $data_master_label = $this->DB_PGSQL->table('tblabel_detail_master')
        //                         ->whereRaw("ipadd like '%$this->ip_address%'")
        //                         ->whereRaw("prdcd like '%$request->prdcd%'")
        //                         ->whereRaw("lrec in ($list_LRec)")
        //                         ->orderBy('tglinsert','desc')
        //                         ->get();
        $delete_master_label = $this->DB_PGSQL->table('tblabel_detail_master')
                                ->whereRaw("ipadd like '%$this->ip_address%'")
                                ->whereRaw("prdcd like '%$request->prdcd%'")
                                // ->whereRaw("lrec in ($list_LRec)")
                                ->delete();
        
        return response()->json(['errors'=>false,'messages'=>'Data Berhasil di  hapus'],200);                               
    }
    

    

    public function cetak(){
        return view('template-print.print');
        // return $this->printPDF();
    }
}
