<?php

namespace App\Http\Controllers;

use App\Traits\LibraryPDF;
use App\Transformers\DataMasterPromoTransformers;
use Illuminate\Http\Request;
use DB;

class PromosiController extends Controller
{
    use LibraryPDF;
    public $DB_PGSQL;
    public $ip_address;
    public $dtabOra;
    public $dtKeluarPromo;
    public $price_allPromo;
    public $price_unitPromo;
    public $jmlLPromo;
    public $flagPromo;
    public $unitPromo;
    public $prodIDPromo;
    public $kpluPromo;
    public $pkpPromo;
    public $LRec;
    public function __construct(Request $request)
    { 
        $this->DB_PGSQL = DB::connection('pgsql');
        $this->get_ip_address($request);

        // try {
        //    $this->DB_PGSQL->beginTransaction();

            
        //    $this->DB_PGSQL->commit();
        // } catch (\Throwable $th) {
            
        //    $this->DB_PGSQL->rollBack();
        //     dd($th);
        //     return response()->json(['errors'=>true,'messages'=>$th->getMessage()],500);
        // }
    }


    public function get_ip_address(Request $request){
        $ipAddress = $request->getClientIp();
        // Get the local IP address
        $hostName = gethostname();
        $ss = gethostbyname($hostName);

        $this->ip_address = str_replace('.', '', $ipAddress);
        // dd($ipAddress,$hostName,$ss, $this->ip_address);

    }

    public function index(){
        return view('cetak-label-price-tag.promo.index');
    }

    public function data_promo(Request $request){

        $promo = $this->master_promo();
        // if (isset($request->prdcd)) {
        //     $promo = $this->master_promo($request->prdcd);
        // } else {
        //     $promo = $this->master_promo();
        // }
        
        $result = [
            'prmd_tglawal' =>null,
            'prmd_tglakhir' =>null
        ];
        foreach ($promo as $item) {
            $startDate = date('Y-m-d',strtotime($item->prmd_tglawal));
            $endDate = date('Y-m-d',strtotime($item->prmd_tglakhir));
            if(!($result['prmd_tglawal']) && !($result['prmd_tglakhir'])){
                $result['prmd_tglawal'] = $item->prmd_tglawal;
                $result['prmd_tglakhir']= $item->prmd_tglawal;
            }
            if ($startDate < $result['prmd_tglawal']) {
                $result['prmd_tglawal']  = $item->prmd_tglawal;
            }
            if ($endDate > $result['prmd_tglakhir']) {
                $result['prmd_tglakhir']  = $item->prmd_tglakhir;
            }
        }

        return DataMasterPromoTransformers::collection($promo)->additional([
            "tgl_awal"=> date("Y/m/d",strtotime($result['prmd_tglawal'])),
            "tgl_akhir"=> date("Y/m/d",strtotime($result['prmd_tglakhir']))
        ]);

    }
    
    public function master_promo($prdcd = null){
        $query_select = $this->DB_PGSQL
                            ->table("tbtr_promomd")
                            ->selectRaw("
                                SUBSTRING(PRMD_PRDCD, 1, 6) as fmkode,
                                MIN(PRMD_HrgJual) as fmjual,
                                PRMD_TGLAWAL, PRMD_TGLAKHIR
                            ")
                            ->whereRaw("DATE_TRUNC('DAY', PRMD_TGLAKHIR) >= CURRENT_DATE")
                            ->whereRaw("DATE_TRUNC('DAY', PRMD_TGLAWAL) <= CURRENT_DATE")
                            ->groupBy($this->DB_PGSQL->raw("SUBSTRING(PRMD_PRDCD, 1, 6)"),"prmd_tglawal","prmd_tglakhir")
                            ->toSql();
        $promo =  $this->DB_PGSQL
                       ->table($this->DB_PGSQL->raw("($query_select) as a, TBMASTER_BARANG as BRG"))
                       ->selectRaw("BRG.*, a.FMJUAL, a.PRMD_TGLAWAL, a.PRMD_TGLAKHIR")
                       ->whereRaw("CONCAT(SUBSTRING(a.fmkode, 1, 6), '0') = BRG_PRDCD");
        if ($prdcd) {
            $promo =  $promo->whereRaw("brg_prdcd like '%$prdcd%'");
        }

        $promo =  $promo->get();
        return $promo;
    }

    public function insert_to_database_promo(Request $request){
        $this->validate($request, [
            'qty' => 'required',
        ]);


        try {
           $this->DB_PGSQL->beginTransaction();

                    $dtabOra5 =  $this->DB_PGSQL
                                    ->table("tbtr_promomd")
                                    ->leftJoin("tbmaster_prodmast",function($join){
                                        $join->on("prmd_prdcd" ,"=" ,"prd_prdcd");
                                    })
                                    ->selectRaw("
                                        prmd_prdcd as fmkode,
                                        prd_deskripsipanjang as desc2,
                                        min(prmd_hrgjual) as fmjual,
                                        prmd_tglawal as fmfrtg,
                                        prmd_tglakhir as fmtotg
                                    ");
                 if ($request->prdcd) {
                    $dtabOra5 = $dtabOra5->whereRaw("PRMD_PRDCD = '" . $request->prdcd. "'");
                 }
                if ($request->tgl_awal && $request->tgl_akhir) {
                    $data_promo =$this->master_promo();
                    $length_array = count($data_promo) -1;
                    $in_prdcd = "(";
                    foreach ($data_promo as $key => $value) {
                        if ($length_array !== $key) {
                            $in_prdcd = $in_prdcd."'$value->brg_prdcd',";
                        } else {
                            $in_prdcd = $in_prdcd."'$value->brg_prdcd')";
                        }
                        
                    }
                    $dtabOra5 = $dtabOra5
                                    ->whereRaw("prmd_prdcd in $in_prdcd");
                                    // ->whereRaw("DATE_TRUNC('DAY', PRMD_TglAkhir) = TO_DATE('" . date('Y-m-d H:i:s', strtotime($request->tgl_awal)) . "', 'YYYYMMDD') ")
                                    // ->whereRaw("DATE_TRUNC('DAY', PRMD_TglAkhir) = TO_DATE('" . date('Y-m-d H:i:s', strtotime($request->tgl_akhir)) . "', 'YYYYMMDD') ");
                }
                    $dtabOra5 = $dtabOra5
                                    ->groupBy("prmd_prdcd", "prd_deskripsipanjang", "prmd_tglawal", "prmd_tglakhir")
                                    ->orderBy("fmkode","asc")
                                    ->get();

                foreach ($dtabOra5 as $p => $value) {
                    if (count($dtabOra5) == 0) {
                        if (empty( $this->dtKeluarPromo)) {
                            $this->dtKeluarPromo = "* " .$value->fmkode . " - " .$value->desc2 . " (Tidak Terdaftar Di TBTR_PROMOMD)";
                        } else {
                            $this->dtKeluarPromo .= "\n* " .$value->fmkode . " - " .$value->desc2 . " (Tidak Terdaftar Di TBTR_PROMOMD)";
                        }
                    } else {
                        $memUnit = "";
                        $memPRDCD = "";
                        $promoDiv = "";
                        $promoDept = "";
                        $promoKatb = "";
    
                        $results = $this->DB_PGSQL
                                        ->table("tbtr_promomd")
                                        ->leftJoin("tbmaster_prodmast",function($join){
                                            $join->on("prmd_prdcd" ,"=" ,"prd_prdcd");
                                        })
                                        ->selectRaw("
                                            prd_prdcd as prdcd, coalesce(prd_kodetag,' ') as ptag, prd_unit as unit,  
                                            prd_kodedivisi as div , prd_kodedepartement as dept, prd_kodekategoribarang katb,  
                                            prmd_hrgjual as fmjual, prd_hrgjual price_a  
                                        ")
                                        ->whereRaw("SUBSTR(PRMD_PRDCD,1,6) = '" .  substr($value->fmkode, 0, 6). "'")
                                        ->whereRaw("DATE_TRUNC('DAY', to_date('".date("Y-m-d H:i:s")."','YYYYMMDD')) BETWEEN DATE_TRUNC('DAY', PRMD_TglAwal) AND DATE_TRUNC('DAY', PRMD_TglAkhir)")
                                        ->whereRaw("PRD_PRDCD IS NOT NULL")
                                        ->get();
                                        
                        foreach ($results as $row) {
                            if (empty($memUnit) && substr($row->prdcd, -1) == "1") {
                                if (strtoupper(trim($row->ptag)) != "C" && strtoupper(trim($row->ptag)) != "X" || strtoupper(trim($row->ptag)) != "Z" && strtoupper(trim($row->ptag)) != "Q") {
                                    $memUnit = $row->unit;
                                    $memPRDCD = $row->prdcd;
                                    $promoDiv = $row->div;
                                    $promoDept = $row->dept;
                                    $promoKatb = $row->katb;
                                    break;
                                }
                            }
                        }
            
                        foreach ($results as $row) {
                            if (empty($memUnit) && substr($row->prdcd, -1) == "2") {
                                if (strtoupper(trim($row->ptag)) != "C" && strtoupper(trim($row->ptag)) != "X" || strtoupper(trim($row->ptag)) != "Z" && strtoupper(trim($row->ptag)) != "Q") {
                                    $memUnit = $row->unit;
                                    $memPRDCD = $row->prdcd;
                                    $promoDiv = $row->div;
                                    $promoDept = $row->dept;
                                    $promoKatb = $row->katb;
                                    break;
                                }
                            }
                        }
            
                        foreach ($results as $row) {
                            if (empty($memUnit) && substr($row->prdcd, -1) == "3") {
                                if (strtoupper(trim($row->ptag)) != "C" && strtoupper(trim($row->ptag)) != "X" || strtoupper(trim($row->ptag)) != "Z" && strtoupper(trim($row->ptag)) != "Q") {
                                    $memUnit = $row->unit;
                                    $memPRDCD = $row->prdcd;
                                    $promoDiv = $row->div;
                                    $promoDept = $row->dept;
                                    $promoKatb = $row->katb;
                                    break;
                                }
                            }
                        }
            
                        foreach ($results as $row) {
                            if (empty($memUnit) && substr($row->prdcd, -1) == "0") {
                                if (strtoupper(trim($row->ptag)) != "C" && strtoupper(trim($row->ptag)) != "X" || strtoupper(trim($row->ptag)) != "Z" && strtoupper(trim($row->ptag)) != "Q") {
                                    $memUnit = $row->unit;
                                    $memPRDCD = $row->prdcd;
                                    $promoDiv = $row->div;
                                    $promoDept = $row->dept;
                                    $promoKatb = $row->katb;
                                    break;
                                }
                            }
                        }
                        if (empty($memUnit)) {
                            if (empty($this->dtKeluarPromo)) {
                                $this->dtKeluarPromo = "* " . $value->fmkode . " - " . $value->desc2 . " (Memiliki salah satu tag 'CZXQ')";
                            } else {
                                $this->dtKeluarPromo .= "\n* " . $value->fmkode . " - " . $value->desc2 . " (Memiliki salah satu tag 'CZXQ')";
                            }
                        } else {
                            $this->LRec = 1;
                            for ($i = 0; $i < intval($request->qty); $i++) {
                                // Assuming you have a function named 'prosesPRDCDviaDBF' for processing
                                $this->proses_prdcd($value->fmkode, $value->desc2, 1, "manual", $promoDiv, $promoDept, $promoKatb);
                            }
                        }
                    }
                }               

            
           $this->DB_PGSQL->commit();
           
           return response()->json(['errors'=>false,'messages'=>"Data Berhasil Di proses",'keluar_promo'=>$this->dtKeluarPromo],200); 
        } catch (\Throwable $th) {
            
           $this->DB_PGSQL->rollBack();
            dd($th);
            return response()->json(['errors'=>true,'messages'=>$th->getMessage()],500);
        }

        // $this->proses_prdcd($request);
        // dd($request->tgl_awal);
        // if($request->prdcd == 'all'){
        //     $messages = "PRDCD'0036870' : Nilai PRMD_HrgJual Di M_HPROMO Lebih Besar Dari PRD_HrgJual Di TBMASTER_PRODMAST";
        // }else {
        //     $messages = "PRDCD '$request->prdcd' Tidak terdaftar";
        // }
        // return response()->json(['errors'=>true,'messages'=>$messages],422);
    }

    public function check_prdcd(Request $request){
        if ($request->prdcd == 'all') {
            return $this->insert_prdcd_all($request);
        } else {
            return $this->check_prdcd_single($request);
        }
        
    }

    public function check_prdcd_single(Request $request){
        $dtProd = [];
        $memUnit = '';
        $memPRDCD = '';
        $keluar = false;

        // Check data in TBTR_PROMOMD and TBMASTER_PRODMAST to be compared later between fmjual <= price_a
        $result = $this->DB_PGSQL
                        ->table($this->DB_PGSQL->raw("tbtr_promomd, tbmaster_prodmast"))
                        ->selectRaw("
                            prd_prdcd,
                            coalesce(prd_kodetag, ' ') as prd_kodetag,
                            prd_unit,
                            prd_kodedivisi,
                            prd_kodedepartement,
                            prd_kodekategoribarang,
                            prmd_hrgjual,
                            prd_hrgjual
                        ")
                        ->whereRaw("DATE_TRUNC('DAY', PRMD_TglAkhir) >= DATE_TRUNC('DAY', TO_DATE('" . now()->format('Ymd') . "', 'YYYYMMDD'))")
                        ->whereRaw("DATE_TRUNC('DAY', PRMD_TglAwal) <= DATE_TRUNC('DAY', TO_DATE('" . now()->format('Ymd') . "', 'YYYYMMDD'))")
                        ->whereRaw("PRD_PRDCD = PRMD_PRDCD")
                        ->whereRaw("SUBSTRING(PRMD_PRDCD, 1, 6) = '" . substr($request->prdcd, 0, 6) . "'")
                        ->get();


        // Continue with the rest of your logic
        foreach ($result as $row) {
            if (substr($row->prd_prdcd, -1) === '1') {
                if ($row->prmd_hrgjual >= $row->prd_hrgjual) {
                    // dd($row);
                    $keluar = true;
                    break;
                }
            }
        }

        if ($keluar) {
            $errors = true;
            $messages = "PRDCD '$request->prdcd' : Nilai PRMD_HrgJual Di M_HPROMO Lebih Besar Dari PRD_HrgJual Di TBMASTER_PRODMAST";
            return response()->json(['errors'=>$errors,'messages'=>$messages],422);
        } 

        // Check if the query result is empty
        if (count($result) === 0) {
            $errors = $keluar;
            $messages =  "PLU '$request->prdcd' Tidak Terdaftar Di TBMASTER_PRODMAST";
            
            return response()->json(['errors'=>$errors,'messages'=>$messages],422);
        } else {
            
            // Assuming $data_promo is an array of associative arrays representing rows

            foreach ($result as $row) {
                // If the last character of PRD_PRDCD is "1"
                if (substr($row->prd_prdcd, -1) === '1') {

                    // If PRD_KodeTag is not 'C', 'X', 'Z', or 'Q'
                    if (trim(strtoupper($row->prd_kodetag)) !== 'C' && trim(strtoupper($row->prd_kodetag)) !== 'X' &&
                        trim(strtoupper($row->prd_kodetag)) !== 'Z' && trim(strtoupper($row->prd_kodetag)) !== 'Q') {
                        $memUnit = $row->prd_unit;
                        $memPRDCD = $row->prd_prdcd;
                        $PromoDiv = $row->prd_kodedivisi;
                        $PromoDept = $row->prd_kodedepartement;
                        $PromoKatb = $row->prd_kodekategoribarang;
                        break;  // Exit the loop
                    }
                }
            }

            foreach ($result as $row) {
                // If the last character of PRD_PRDCD is "2"
                if (substr($row->prd_prdcd, -1) === '2') {
                    // If PRMD_HrgJual is greater than or equal to PRD_HrgJual
                    // if ($row->prmd_hrgjual >= $row->prd_hrgjual) {
                    //     $keluar = true;
                    //     break;  // Exit the loop
                    // }
            
                    // If PRD_KodeTag is not 'C', 'X', 'Z', or 'Q'
                    if (trim(strtoupper($row->prd_kodetag)) !== 'C' && trim(strtoupper($row->prd_kodetag)) !== 'X' &&
                        trim(strtoupper($row->prd_kodetag)) !== 'Z' && trim(strtoupper($row->prd_kodetag)) !== 'Q') {
                        $memUnit = $row->prd_unit;
                        $memPRDCD = $row->prd_prdcd;
                        $PromoDiv = $row->prd_kodedivisi;
                        $PromoDept = $row->prd_kodedepartement;
                        $PromoKatb = $row->prd_kodekategoribarang;
                        break;  // Exit the loop
                    }
                }
            }


            foreach ($result as $row) {
                // If the last character of PRD_PRDCD is "3"
                if (substr($row->prd_prdcd, -1) === '3') {
                    // If PRMD_HrgJual is greater than or equal to PRD_HrgJual
                    if ($row->prmd_hrgjual >= $row->prd_hrgjual) {
                        $keluar = true;
                        break;  // Exit the loop
                    }

                    // If PRD_KodeTag is not 'C', 'X', 'Z', or 'Q'
                    if (trim(strtoupper($row->prd_kodetag)) !== 'C' && trim(strtoupper($row->prd_kodetag)) !== 'X' &&
                        trim(strtoupper($row->prd_kodetag)) !== 'Z' && trim(strtoupper($row->prd_kodetag)) !== 'Q') {
                        $memUnit = $row->prd_unit;
                        $memPRDCD = $row->prd_prdcd;
                        $PromoDiv = $row->prd_kodedivisi;
                        $PromoDept = $row->prd_kodedepartement;
                        $PromoKatb = $row->prd_kodekategoribarang;
                        break;  // Exit the loop
                    }
                }
            }

            foreach ($result as $row) {
                // If the last character of PRD_PRDCD is "0"
                if (substr($row->prd_prdcd, -1) === '0') {
                    // If PRMD_HrgJual is greater than or equal to PRD_HrgJual
                    if ($row->prmd_hrgjual >= $row->prd_hrgjual) {
                        $keluar = true;
                        break;  // Exit the loop
                    }

                    // If PRD_KodeTag is not 'C', 'X', 'Z', or 'Q'
                    if (trim(strtoupper($row->prd_kodetag)) !== 'C' && trim(strtoupper($row->prd_kodetag)) !== 'X' &&
                        trim(strtoupper($row->prd_kodetag)) !== 'Z' && trim(strtoupper($row->prd_kodetag)) !== 'Q') {
                        $memUnit = $row->prd_unit;
                        $memPRDCD = $row->prd_prdcd;
                        $PromoDiv = $row->prd_kodedivisi;
                        $PromoDept = $row->prd_kodedepartement;
                        $PromoKatb = $row->prd_kodekategoribarang;
                        break;  // Exit the loop
                    }
                }
            }



            //----------------
            //----------------
            if (empty($memUnit)) {
                // If memUnit is empty, meaning data in prodmast has tags 'C', 'Z', 'Q', 'X'
                $errors = true;
                $messages ="Produk Memiliki Salah Satu Tag 'C', 'Z', 'Q', 'X' di TBMASTER_PRODMAST";
            } else {

               $query_result = $this->DB_PGSQL
                                    ->table("tbtr_promomd")
                                    ->selectRaw("
                                        substr(prmd_prdcd,1,6) as fmkode,  
                                        min(prmd_hrgjual) as fmjual,  
                                        prmd_tglawal as fmfrtg, 
                                        prmd_tglakhir as fmtotg  
                                    ")
                                    ->whereRaw("DATE_TRUNC('DAY', prmd_tglakhir) >= DATE_TRUNC('DAY', current_date)")
                                    ->whereRaw("DATE_TRUNC('DAY', prmd_tglawal) <= DATE_TRUNC('DAY', current_date)")
                                    ->whereRaw("PRMD_PRDCD='$memPRDCD'")
                                    ->groupBy($this->DB_PGSQL->raw("SUBSTR(PRMD_PRDCD,1,6)"),"prmd_tglawal","prmd_tglakhir")
                                    ->toSql();
               $result = $this->DB_PGSQL
                                ->table($this->DB_PGSQL->raw("($query_result) as a, tbmaster_barang as brg "))
                                ->selectRaw("
                                    BRG.*, a.FMJUAL, a.FMFRTG, a.FMTOTG 
                                ")
                                ->whereRaw("SUBSTR(a.FMKODE,1,6)=SUBSTR(BRG_PRDCD,1,6)")
                                ->get();
            }
            //----------------
            //----------------

            // Assuming that $data_promo is your data table

            if (count($result)) {
                return response()->json(['errors'=>false,'messages'=>'Data Tersedia','callback' => $result],200);
            } else {
                return response()->json(['errors'=>true,'messages'=>'Data tidak tersedia'],404);
            }


        }

    }
    public function insert_prdcd_all(Request $request){
        return response()->json(['errors'=>false,'messages'=>"PRDCD '0036870' : Nilai PRMD_HrgJual Di M_HPROMO Lebih Besar Dari PRD_HrgJual Di TBMASTER_PRODMAST"],422);
        try {
            $this->DB_PGSQL->beginTransaction();

            
                $i = 0;
                $p = 0;
                $memUnit = "";
                $memPRDCD = "";
                $z = 0;
                $keluar = false;
                $keluar = false;
                $promoDiv = "";
                $promoDept = "";
                $promoKatb = "";
                $plu_not_found = [];

                $keluar = false;
                $memUnit = "";
                $memPRDCD = "";
                $promoDiv = "";
                $promoDept = "";
                $promoKatb = "";
        
                $strmysql = $this->DB_PGSQL->table("temp_rowpromo")->delete();
                $data_promo = $this->master_promo();
        
                foreach ($data_promo as $key => $result) {
                    $this->DB_PGSQL->table("temp_rowpromo")->insert(["ipadd"=>$this->ip_address,"rowindex"=>$key]);
                }
                
        
                $strmysql = $this->DB_PGSQL
                                 ->table("temp_rowpromo")
                                 ->whereRaw("ipadd = '$this->ip_address'")
                                 ->get();
               
                foreach ($strmysql as $key => $result) {
                    $sql = $this->DB_PGSQL
                                ->table("tbtr_promomd")
                                ->selectRaw("
                                    PRD_PRDCD, PRD_KODETAG, PRD_UNIT, PRD_KodeDivisi, PRD_KodeDepartement, PRD_KodeKategoriBarang, PRMD_HrgJual, PRD_HrgJual
                                ")
                                ->leftJoin("tbmaster_prodmast",function($join){
                                    $join->on("prmd_prdcd" ,"=" ,"prd_prdcd");
                                })
                                ->whereRaw("prmd_tglakhir::date >= current_date::date")
                                ->whereRaw("prmd_tglawal::date <= current_date::date")
                                ->whereRaw("SUBSTR(PRMD_PRDCD,1,6)='" . substr($data_promo[$key]->fmkode, 0, 6) . "'")
                                ->get();
    
                    if (count($sql) === 0) {
                        $plu_not_found[] = "PLU [" . $data_promo[$key]->fmkode. "] tidak terdaftar di PRODMAST";
                        // echo "PLU [" . $data_promo[$key]->fmkode. "] tidak terdaftar di PRODMAST" . PHP_EOL;
                    } 
                    
                }    





                // Loop through the rows of data_promo
                for ($z = 0; $z < count($data_promo); $z++) {
                    // Check if the last character of PRD_PRDCD is "1"
                    if (substr($data_promo[$z]->prd_prdcd, -1) === "1") {
                        // Check if PRMD_HrgJual is greater than or equal to PRD_HrgJual
                        if ($data_promo[$z]->prmd_hrgjual >= $data_promo[$z]->prd_hrgjual) {
                            $keluar = true;
                            break;
                        }

                        // Check the conditions for memUnit, memPRDCD, and other variables
                        if (
                            strtoupper(trim($data_promo[$z]->prd_kodetag)) !== "C" && strtoupper(trim($data_promo[$z]->prd_kodetag)) !== "X" ||
                            strtoupper(trim($data_promo[$z]->prd_kodetag)) !== "Z" && strtoupper(trim($data_promo[$z]->prd_kodetag)) !== "Q"
                        ){
                            $memUnit = $data_promo[$z]->prd_unit;
                            $memPRDCD = $data_promo[$z]->prd_prdcd;
                            $promoDiv = $data_promo[$z]->prd_kodedivisi;
                            $promoDept = $data_promo[$z]->prd_kodedepartement;
                            $promoKatb = $data_promo[$z]->prd_kodekategoribarang;
                            break;
                        }
                    }
                }

                // Loop through the rows of data_promo
                for ($z = 0; $z < count($data_promo); $z++) {
                    // Check if keluar is false
                    if (!$keluar) {
                        // Check if memUnit is empty
                        if (empty($memUnit)) {
                            // Check if the last character of PRD_PRDCD is "2"
                            if (substr($data_promo[$z]->prd_prdcd, -1) === "2") {
                                // Check if PRMD_HrgJual is greater than or equal to PRD_HrgJual
                                if ($data_promo[$z]->prmd_hrgjual >= $data_promo[$z]->prd_hrgjual) {
                                    $keluar = true;
                                    break;
                                }

                                // Check the conditions for memUnit, memPRDCD, and other variables
                                if (
                                    strtoupper(trim($data_promo[$z]->prd_kodetag)) !== "C" && strtoupper(trim($data_promo[$z]->prd_kodetag)) !== "X" ||
                                    strtoupper(trim($data_promo[$z]->prd_kodetag)) !== "Z" && strtoupper(trim($data_promo[$z]->prd_kodetag)) !== "Q"
                                ) {
                                    $memUnit = $data_promo[$z]->prd_unit;
                                    $memPRDCD = $data_promo[$z]->prd_prdcd;
                                    $promoDiv = $data_promo[$z]->prd_kodedivisi;
                                    $promoDept = $data_promo[$z]->prd_kodedepartement;
                                    $promoKatb = $data_promo[$z]->prd_kodekategoribarang;
                                    break;
                                }
                            }
                        }
                        // else {
                        //     break;
                        // }
                    } 
                    // else {
                    //     break;
                    // }
                }

                // Loop through the rows of data_promo
                foreach ($data_promo as $z => $row) {
                    // Check if keluar is false
                    if (!$keluar) {
                        // Check if memUnit is empty
                        if (empty($memUnit)) {
                            // Check if the last character of PRD_PRDCD is "3"
                            if (substr($row->prd_prdcd, -1) === "3") {
                                // Check if PRMD_HrgJual is greater than or equal to PRD_HrgJual
                                if ($row->prmd_hrgjual >= $row->prd_hrgjual) {
                                    $keluar = true;
                                    break;
                                }

                                // Check the conditions for memUnit, memPRDCD, and other variables
                                if (
                                    strtoupper(trim($row->prd_kodetag)) !== "C" && strtoupper(trim($row->prd_kodetag)) !== "X" ||
                                    strtoupper(trim($row->prd_kodetag)) !== "Z" && strtoupper(trim($row->prd_kodetag)) !== "Q"
                                ) {
                                    $memUnit = $row->prd_unit;
                                    $memPRDCD = $row->prd_prdcd;
                                    $promoDiv = $row->prd_kodedivisi;
                                    $promoDept = $row->prd_kodedepartement;
                                    $promoKatb = $row->prd_kodekategoribarang;
                                    break;
                                }
                            }
                        } 
                        // else {
                        //     break;
                        // }
                    } 
                    // else {
                    //     break;
                    // }
                }

                // Loop through the rows of data_promo
                foreach ($data_promo as $z => $row) {
                    // Check if keluar is false
                    if (!$keluar) {
                        // Check if memUnit is empty
                        if (empty($memUnit)) {
                            // Check if the last character of PRD_PRDCD is "0"
                            if (substr($row->prd_prdcd, -1) === "0") {
                                // Check if PRMD_HrgJual is greater than or equal to PRD_HrgJual
                                if ($row->prmd_hrgjual >= $row->prd_hrgjual) {
                                    $keluar = true;
                                    break;
                                }

                                // Check the conditions for memUnit, memPRDCD, and other variables
                                if (
                                    strtoupper(trim($row->ptag)) !== "C" && strtoupper(trim($row->ptag)) !== "X" ||
                                    strtoupper(trim($row->ptag)) !== "Z" && strtoupper(trim($row->ptag)) !== "Q"
                                ) {
                                    $memUnit = $row->unit;
                                    $memPRDCD = $row->prdcd;
                                    $promoDiv = $row->div;
                                    $promoDept = $row->dept;
                                    $promoKatb = $row->katb;
                                    break;
                                }
                            }
                        } 
                        // else {
                        //     break;
                        // }
                    } 
                    // else {
                    //     break;
                    // }
                }

                if ($keluar) {
                    // Display message when keluar is true
                    echo "PRDCD [" . $gridProduk[$dtabOra4[$i][1]][0] . "] : Nilai PRMD_HrgJual Di TBTR_PROMOMD lebih besar dari PRD_HrgJual di PRODMAST\n";
                } elseif (empty($memUnit)) {
                    // Display message when memUnit is empty
                    echo "Produk memiliki salah satu tag 'C', 'Z', 'Q', 'X' di TBMASTER_PRODMAST\n";
                } else {
                    // Fetch data for insertion
                    $result = DB::select("
                        SELECT BRG.*, a.FMKODE, a.FMJUAL, a.FMFRTG, a.FMTOTG
                        FROM (
                            SELECT
                                SUBSTR(PRMD_PRDCD, 6) as fmkode,
                                min(PRMD_Hrjual) as fmjual,
                                PRMD_TglAwal as fmfrtg,
                                PRMD_TglAkhir as fmtotg
                            FROM TBTR_PROMOMD
                            WHERE
                                DATE_TRUNC('DAY', PRMD_TglAkhir) >= DATE_TRUNC('DAY', TO_DATE('" . now()->format('Ymd') . "','YYYYMMDD')) AND
                                DATE_TRUNC('DAY', PRMD_TglAkhir) <= DATE_TRUNC('DAY', TO_DATE('" . now()->format('Ymd') . "','YYYYMMDD')) AND
                                PRMD_PRDCD='" . $memPRDCD . "'
                            GROUP BY SUBSTR(PRMD_PRCD, 1, 6), PRMD_TglAwal, PRMD_TglAkhir
                        ) a, TBMASTER_BARANG BRG
                        WHERE SUBSTR(a.FMKODE, 1, 6) = SUBSTR(BRG_PRDCD, 1, 6)
                    ");

                    if (!empty($result)) {
                        // Insert into Tb_SPromo table
                        DB::insert("
                            INSERT INTO Tb_SPromo
                            VALUES (
                                '" . $IPlocal . "',
                                1,
                                '" . now()->format('Y/m/d H:i:s') . "',
                                '" . $result[0]->fmkode . "',
                                '" . str_replace("'", "''", $result[0]->BRG_Merk) . "',
                                '" . str_replace("'", "''", $result[0]->BRG_Nama) . "',
                                '" . str_replace("'", "''", $result[0]->BRG_Flavor . ' ' . $result[0]->BRG_Ukuran) . "',
                                " . $result[0]->fmjual . ",
                                '" . now()->format('Y/m/d', strtotime($result[0]->fmfrtg)) . "',
                                '" . now()->format('Y/m/d', strtotime($result[0]->fmtotg)) . "',
                                '" . $memUnit . "',
                                " . $PRec . ",
                                '" . $promoDiv . "',
                                '" . $promoDept . "',
                                '" . $promoKatb . "'
                            )
                        ");

                        // Increment PRec
                        $PRec += 1;
                    }
                }
                $strsql = "SELECT * FROM Tb_SPromo WHERE IPAdd='" . str_replace(".", "", $IPlocal) . "' ORDER BY tglInsert ASC";

                // Assuming ProsesOra4 function is not needed in Laravel, you can directly use the DB::select method
                $results = DB::select($strsql);




                
                            

            $this->DB_PGSQL->commit();
        } catch (\Throwable $th) {
            
            $this->DB_PGSQL->rollBack();
            // dd($th);
            return response()->json(['errors'=>true,'messages'=>$th->getMessage()],500);
        }



    }

    public function proses_prdcd($prdcd = null,$desc = null,$jmlPrint = 1,$tipe = null,$div = null,$dept = null,$katb = null,){
       
        // Initialize variables
        $Awal = '';
        $Akhir = '';
        $this->jmlhsPromo = 0;

        $flagPromo = '';
        $price_aPromo = array_fill(0, 5, 0);
        $price_allPromo = array_fill(0, 5, 0);
        $price_unitPromo = array_fill(0, 5, 0);
        $unitPromo = array_fill(0, 5, '');
        $jmlLPromo = array_fill(0, 5, '');

        $klikPromo = false;
        $flagPromo = '';

        // Build the first query
        $results = $this->DB_PGSQL
                        ->table('tbmaster_prodmast')
                        ->join('tbmaster_prodcrm', 'prd_prdcd', '=', 'prc_pluigr')
                        ->selectRaw("PRD_PRDCD as prdcd, COALESCE(PRC_KodeTag, ' ') as ptag")
                        ->whereRaw("PRD_PRDCD = PRC_PLUIGR") 
                        ->whereRaw("SUBSTR(PRD_PRDCD, 1, 6) = '" . substr($prdcd, 0, 6) . "'") 
                        ->whereRaw("COALESCE(PRC_KodeTag, ' ') NOT IN ('N', 'O', 'H', 'X', 'Q')") 
                        ->get();

        // Check if the result is not empty
        if ($results->count() > 0) {
            $desc .= ' O';
        }
        
        // Build the second query
        $results = $this->DB_PGSQL->table('tbmaster_prodmast')
            ->leftJoin('tbtr_promomd', 'prd_prdcd', '=', 'prmd_prdcd')
            ->leftJoin($this->DB_PGSQL->raw('(SELECT brc_prdcd, MAX(brc_barcode) as barc, NULL as bar2
                FROM tbmaster_barcode
                GROUP BY brc_prdcd
                HAVING COUNT(brc_prdcd) = 1
                UNION
                SELECT brc_prdcd, MIN(brc_barcode) as barc, MAX(brc_barcode) as bar2
                FROM tbmaster_barcode
                GROUP BY brc_prdcd
                HAVING COUNT(brc_prdcd) = 2) BRC'), 'brc_prdcd', '=', 'prd_prdcd')
            ->selectRaw("
                prd_prdcd as prdcd, prd_plumcg as kplu, brc.barc, brc.bar2,
                prd_deskripsipanjang as desc2, prd_minjual as minj, prd_frac as frac,
                prd_unit as unit, coalesce(prd_kodetag, ' ') as ptag,
                prd_flagbarcode1 as fmbsts, prd_kategoritoko as kttk,
                prd_kodecabang as kcab, prd_hrgjual as price_a,
                prd_flagbkp1 as pkp, prd_flagbkp2 as pkp2,
                prd_kodedivisi as div, prd_kodedepartement as dept, prd_kodekategoribarang as katb,
                prmd_hrgjual as fmjual, prmd_tglawal as fmfrtg, prmd_tglakhir as fmtotg
            ")
            ->whereRaw("SUBSTR(PRD_PRDCD, 1, 6) = '" . substr($prdcd, 0, 6) . "'")
            ->whereRaw("DATE_TRUNC('DAY', TO_DATE('" . date('Ymd') . "', 'YYYYMMDD')) BETWEEN DATE_TRUNC('DAY', PRMD_TglAwal) AND DATE_TRUNC('DAY', PRMD_TglAkhir)")
            ->get();

            /**
             * start 
             */

            if (count($results)) {
                $Awal = $results->first()->fmfrtg;
                $Akhir = $results->first()->fmtotg;
                $count = $this->DB_PGSQL->table('tbpromo')->insert([
                    'ipadd' => $this->ip_address,
                    'prdcd' => substr(trim($prdcd), 0, 6),
                    'nama' => str_replace("'", "''", trim($desc)),
                ]);
                $temp_result = [];
                foreach ($results as $key => $value) {
                    $temp_result []= (array)$value;
                }
                
                $this->dtabOra = $temp_result;
                // substr($row->prdcd, -1) == "0"
                foreach ($results as $i => $row) {
                    if (substr($row->prdcd, -1) == "0") {
                        if ($row->ptag != "Z" && $row->ptag != "X" && $row->ptag != "C" && $row->ptag != "Q") {
                            if ($row->fmjual >= $row->price_a) {
                                if (empty($dtKeluarPromo)) {
                                    $this->dtKeluarPromo = "* " . $row->prdcd . " - " . trim($desc) . " (PRMD_HRGJUAL >= PRDCD_HRGJUAL)";
                                } else {
                                    $this->dtKeluarPromo .= PHP_EOL . "* " . $row->prdcd . " - " . trim($desc) . " (PRMD_HRGJUAL >= PRDCD_HRGJUAL)";
                                }
                                break;
                            } else {
                                $this->cek_price($i, $this->jmlhsPromo);
                                $this->kpluPromo = $row->kplu;
                                $this->unitPromo[$this->jmlhsPromo] = $row->unit;
                                if (empty($pkpPromo)) {
                                    $pkpPromo = $row->pkp . $row->pkp2;
                                }
                                $this->prodIDPromo = $prdcd;
                                $this->jmlhsPromo++;
                                break;
                            }
                        } else {
                            if (empty($dtKeluarPromo)) {
                                $dtKeluarPromo = "* " . $row->prdcd . " - " . trim($desc) . " (TAG '" . $row->ptag . "')";
                            } else {
                                $dtKeluarPromo .= PHP_EOL . "* " . $row->prdcd . " - " . trim($desc) . " (TAG '" . $row->ptag . "')";
                            }
                            break;
                        }
                    }
                }
    
                // substr($row["prdcd"], -1) == "3"
                $this->jmlhsPromo = 0;
                foreach ($results as $i => $row) {
                    if (substr($row->prdcd, -1) == "3") {
                        if ($row->ptag != "Z" && $row->ptag != "X" && $row->ptag != "C" && $row->ptag != "Q") {
                            if ($row->kttk == "" && $row->kcab == "") {
                                // break;
                            } elseif ($row->fmjual >= $row->price_a) {
                                if (empty($this->dtKeluarPromo)) {
                                    $this->dtKeluarPromo = "* " . $row->prdcd . " - " . trim($desc) . " (PRMD_HRGJUAL >= PRDCD_HRGJUAL)";
                                } else {
                                    $this->dtKeluarPromo .= PHP_EOL . "* " . $row->prdcd . " - " . trim($desc) . " (PRMD_HRGJUAL >= PRDCD_HRGJUAL)";
                                }
                                // break;
                            } else {
                                $this->cek_price($i, $this->jmlhsPromo);
                                $this->unitPromo[$this->jmlhsPromo] = $row->unit;
                                if (!empty($this->prodIDPromo)) {
                                    $this->prodIDPromo .= "/3";
                                } else {
                                    $this->prodIDPromo = $row->prdcd;
                                }
                                if (empty($this->$pkpPromo)) {
                                    $this->pkpPromo = $row->pkp . $row->pkp2;
                                }
                                $this->jmlhsPromo++;
                                // break;
                            }
                        } else {
                            if (empty($this->dtKeluarPromo)) {
                                $this->dtKeluarPromo = "* " . $row->prdcd . " - " . trim($desc) . " (TAG '" . $row->ptag . "')";
                            } else {
                                $this->dtKeluarPromo .= PHP_EOL . "* " . $row->prdcd . " - " . trim($desc) . " (TAG '" . $row->ptag . "')";
                            }
                            // break;
                        }
                    }
                }
                
                // substr($row["prdcd"], -1) == "2"
    
                $this->jmlhsPromo = 0;
                foreach ($results as $i => $row) {
                    if (substr($row->prdcd, -1) == "2") {
                        if ($row->ptag != "Z" && $row->ptag != "X" && $row->ptag != "C" && $row->ptag != "Q") {
                            if ($row->kttk == "" && $row->kcab == "") {
                                // break;
                            } elseif ($row->fmjual >= $row->price_a) {
                                if (empty($this->dtKeluarPromo)) {
                                    $this->dtKeluarPromo = "* " . $row->prdcd . " - " . trim($desc) . " (PRMD_HRGJUAL >= PRDCD_HRGJUAL)";
                                } else {
                                    $this->dtKeluarPromo .= PHP_EOL . "* " . $row->prdcd . " - " . trim($desc) . " (PRMD_HRGJUAL >= PRDCD_HRGJUAL)";
                                }
                                // break;
                            } else {
                                $this->cek_price($i, $this->jmlhsPromo);
                                $this->unitPromo[$this->jmlhsPromo] = $row->unit;
                                if (!empty($this->prodIDPromo)) {
                                    $this->prodIDPromo .= "/2";
                                } else {
                                    $this->prodIDPromo = $row->prdcd;
                                }
                                if (empty($this->pkpPromo)) {
                                    $this->pkpPromo = $row->pkp . $row->pkp2;
                                }
                                $this->jmlhsPromo++;
                                // break;
                            }
                        } else {
                            if (empty($this->dtKeluarPromo)) {
                                $this->dtKeluarPromo = "* " . $row->prdcd . " - " . trim($desc) . " (TAG '" . $row->ptag . "')";
                            } else {
                                $this->dtKeluarPromo .= PHP_EOL . "* " . $row->prdcd . " - " . trim($desc) . " (TAG '" . $row->ptag . "')";
                            }
                            // break;
                        }
                    }
                }
            }

            // Continue with the rest of your PHP code...
             /**
             * End
             */

            // Check if jmlhsPromo is greater than 3
            if ($this->jmlhsPromo > 3) {
                $this->prodIDPromo = str_replace("0/", "", $this->prodIDPromo);

                // Shift array elements for indices 0 to 2
                for ($i = 0; $i < 2; $i++) {
                    $this->price_aPromo[$i] = $this->price_aPromo[$i + 1];
                    $this->price_unitPromo[$i] = $this->price_unitPromo[$i + 1];
                    $this->price_allPromo[$i] = $this->price_allPromo[$i + 1];
                    $this->jmlLPromo[$i] = $this->jmlLPromo[$i + 1];
                    $this->unitPromo[$i] = $this->unitPromo[$i + 1];
                }
            }

            $i = 4;
            while ($i > 0) {
                if (isset($this->price_allPromo[$i])) {
                    if ($this->price_allPromo[$i] == $this->price_allPromo[$i - 1] && $this->price_allPromo[$i] != 0 && $this->price_allPromo[$i - 1] != 0) {
                        $this->price_allPromo[$i] = 0;
                        $this->price_aPromo[$i] = 0;
                        $this->price_unitPromo[$i] = 0;
                        $this->jmlLPromo[$i] = "";
                        $this->unitPromo[$i] = "";
                        $this->prodIDPromo = substr($this->prodIDPromo, 0, strrpos($this->prodIDPromo, "/"));
                    }
                }
                $i = $i - 1;
            }

            // Check if div is 6 in the first row of dtabOra
            // foreach ($results as $key => $result) {
                if ($results->first()->div == "6") {
                    for ($i = 1; $i < 3; $i++) {
                        $this->price_aPromo[$i] = 0;
                        $this->price_allPromo[$i] = 0;
                        $this->price_unitPromo[$i] = 0;
                        $this->unitPromo[$i] = "";
                        $this->jmlLPromo[$i] = "";
                    }
                }
            // }

            if ($this->prodIDPromo) {
                // $LRec = 1;
                // for ($i = 1; $i < $jmlPrint; $i++) {

                       $this->DB_PGSQL
                            ->table('tbpromo_detail_master')
                            ->insert([
                                'ipadd' => $this->ip_address,
                                'prdcd' => $this->prodIDPromo ?? null,
                                'kplu' => $this->kpluPromo ?? null,
                                'nama1' => mb_substr($desc, 0, 40) ?? null,
                                'nama2' => mb_substr($desc, 0, 40) ?? null,
                                'jml1' => $this->jmlLPromo[0] ?? null,
                                'jml2' => $this->jmlLPromo[1] ?? null,
                                'jml3' => $this->jmlLPromo[2] ?? null,
                                'unit1' => $this->unitPromo[0] ?? null,
                                'unit2' => $this->unitPromo[1] ?? null,
                                'unit3' => $this->unitPromo[2] ?? null,
                                'price_all1' => $this->price_allPromo[0] ?? null,
                                'price_all2' => $this->price_allPromo[1] ?? null,
                                'price_all3' => $this->price_allPromo[2] ?? null,
                                'price_unit1' => $this->price_unitPromo[0] ?? null,
                                'price_unit2' => $this->price_unitPromo[1] ?? null,
                                'price_unit3' => $this->price_unitPromo[2] ?? null,
                                'tglawal' => $Awal ? date('Y-m-d H:i:s') : null,
                                'tglakhir' => $Akhir ? date('Y-m-d H:i:s') : null,
                                'statusppn' => $this->pkpPromo ?? null,
                                'tglinsert' => date('Y-m-d H:i:s'),
                                'lrec' => $this->LRec,
                                'div' => $div,
                                'dept' => $dept,
                                'katb' => $katb,
                                'prnumber' => 1
                            ]);

                    $this->LRec += 1;
                // }
            }


    }

    public function cek_price($x= null , $y = null){

        if (($this->dtabOra[$x]["frac"] > $this->dtabOra[$x]["minj"]) || ($this->dtabOra[$x]["frac"] == $this->dtabOra[$x]["minj"])) {
            $this->jmlPromo[$y] = (int)$this->dtabOra[$x]["frac"];
            if ($this->flagPromo != "*") {
                $this->price_allPromo[$y] = (int)$this->dtabOra[$x]["fmjual"];
            }
        } elseif ($this->dtabOra[$x]["frac"] < $this->dtabOra[$x]["minj"]) {
            $this->jmlPromo[$y] = (int)$this->dtabOra[$x]["minj"];
            if ($this->flagPromo != "*") {
                $this->price_allPromo[$y] = (int)$this->dtabOra[$x]["fmjual"] * $this->dtabOra[$x]["minj"];
            }
        }

        if (trim($this->dtabOra[$x]["unit"]) == "KG") {
            $this->price_allPromo[$y] = (int)$this->dtabOra[$x]["fmjual"] * (int)$this->jmlPromo[$y] / 1000;
            $this->price_unitPromo[$y] = ($this->price_allPromo[$y] / $this->jmlPromo[$y]) * 1000;
        } else {
            $this->price_unitPromo[$y] = ($this->price_allPromo[$y] / $this->jmlPromo[$y]) * 1;
        }
        $this->jmlLPromo[$y] = "/" . $this->jmlPromo[$y];


    }

}
