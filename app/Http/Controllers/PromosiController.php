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
        if($request->prdcd == 'all'){
            $messages = "PRDCD'0036870' : Nilai PRMD_HrgJual Di M_HPROMO Lebih Besar Dari PRD_HrgJual Di TBMASTER_PRODMAST";
        }else {
            $messages = "PRDCD '$request->prdcd' Tidak terdaftar";
        }
        return response()->json(['errors'=>true,'messages'=>$messages],422);
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

}
