<?php

namespace App\Http\Controllers;

use App\Traits\getDataCabang;
use App\Traits\LibraryCSV;
use App\Transformers\DataSMSTransformers;
use Illuminate\Http\Request;
use Faker\Factory as Faker;
use DB;

class SMSController extends Controller
{
    use LibraryCSV;
    public $DB_ORACLE;
    public $no_db = false;
    public function __construct() {
        // $this->no_db = true;
        if(!( $this->no_db)){
            $this->DB_ORACLE = DB::connection('pgsql');
        }

        // try {
        //     $this->DB_ORACLE->beginTransaction();

            
        //     $this->DB_ORACLE->commit();
        // } catch (\Throwable $th) {
            
        //     $this->DB_ORACLE->rollBack();
        //     dd($th);
        //     return response()->json(['errors'=>true,'messages'=>$th->getMessage()],500);
        // }
        // if ($this->no_db) {
        //         $json_data = '[]';
        //         $result = json_decode($json_data);
        // }else{
        //     $result = $this->DB_ORACLE
        //                    ->table($this->DB_ORACLE->raw(""))
        //                    ->orderBy("","asc")
        //                    ->get();

        // }
    }

    public function index(){
        return view('member-ho.menu.sms');
    }
    
    public function view(Request $request){
        
        $page = $request->page?$request->page:1;
            if ($this->no_db) {
                $json_data = '[{"cab_namacabang" : "INDOGROSIR MEDAN","sms_kodeigr" : "15","sms_kodemonitoring" : "2009021701","sms_namasms" : "Harga Heboh Igr Mdn","sms_tglawal" : "2009-02-18","sms_tglakhir" : "2009-02-18","cabang" : "15 - INDOGROSIR MEDAN","kodemonitoring" : "2009021701","namasms" : "Harga Heboh Igr Mdn","tanggalawalpromosi" : "2009-02-18","tanggalakhirpromosi" : "2009-02-18","rnum" : 1},{"cab_namacabang" : "INDOGROSIR CIPINANG","sms_kodeigr" : "01","sms_kodemonitoring" : "2009022301","sms_namasms" : "Harga Hemat 10 Igr Cpg","sms_tglawal" : "2009-02-27","sms_tglakhir" : "2009-03-05","cabang" : "01 - INDOGROSIR CIPINANG","kodemonitoring" : "2009022301","namasms" : "Harga Hemat 10 Igr Cpg","tanggalawalpromosi" : "2009-02-27","tanggalakhirpromosi" : "2009-03-05","rnum" : 2},{"cab_namacabang" : "INDOGROSIR TANGERANG","sms_kodeigr" : "05","sms_kodemonitoring" : "2009040701","sms_namasms" : "Harga Hemat 16 Igr tgr","sms_tglawal" : "2009-04-10","sms_tglakhir" : "2009-04-16","cabang" : "05 - INDOGROSIR TANGERANG","kodemonitoring" : "2009040701","namasms" : "Harga Hemat 16 Igr tgr","tanggalawalpromosi" : "2009-04-10","tanggalakhirpromosi" : "2009-04-16","rnum" : 3},{"cab_namacabang" : "INDOGROSIR SURABAYA","sms_kodeigr" : "03","sms_kodemonitoring" : "2009041601","sms_namasms" : "Harga Hemat 17 Igr Sby","sms_tglawal" : "2009-04-17","sms_tglakhir" : "2009-04-23","cabang" : "03 - INDOGROSIR SURABAYA","kodemonitoring" : "2009041601","namasms" : "Harga Hemat 17 Igr Sby","tanggalawalpromosi" : "2009-04-17","tanggalakhirpromosi" : "2009-04-23","rnum" : 4},{"cab_namacabang" : "INDOGROSIR MEDAN","sms_kodeigr" : "15","sms_kodemonitoring" : "2009041602","sms_namasms" : "Harga Hemat 17 Igr Mdn","sms_tglawal" : "2009-04-17","sms_tglakhir" : "2009-04-23","cabang" : "15 - INDOGROSIR MEDAN","kodemonitoring" : "2009041602","namasms" : "Harga Hemat 17 Igr Mdn","tanggalawalpromosi" : "2009-04-17","tanggalakhirpromosi" : "2009-04-23","rnum" : 5},{"cab_namacabang" : "INDOGROSIR MEDAN","sms_kodeigr" : "15","sms_kodemonitoring" : "2009042801","sms_namasms" : "Harga Heboh Igr Mdn 29Apr09","sms_tglawal" : "2009-04-29","sms_tglakhir" : "2009-04-29","cabang" : "15 - INDOGROSIR MEDAN","kodemonitoring" : "2009042801","namasms" : "Harga Heboh Igr Mdn 29Apr09","tanggalawalpromosi" : "2009-04-29","tanggalakhirpromosi" : "2009-04-29","rnum" : 6},{"cab_namacabang" : "INDOGROSIR MEDAN","sms_kodeigr" : "15","sms_kodemonitoring" : "2009052201","sms_namasms" : "Harga Heboh Igr Mdn 25Mei09","sms_tglawal" : "2009-05-25","sms_tglakhir" : "2009-05-25","cabang" : "15 - INDOGROSIR MEDAN","kodemonitoring" : "2009052201","namasms" : "Harga Heboh Igr Mdn 25Mei09","tanggalawalpromosi" : "2009-05-25","tanggalakhirpromosi" : "2009-05-25","rnum" : 7},{"cab_namacabang" : "INDOGROSIR SURABAYA","sms_kodeigr" : "03","sms_kodemonitoring" : "2009052604","sms_namasms" : "Harga Heboh Igr Sby 27Mei09","sms_tglawal" : "2009-05-27","sms_tglakhir" : "2009-05-27","cabang" : "03 - INDOGROSIR SURABAYA","kodemonitoring" : "2009052604","namasms" : "Harga Heboh Igr Sby 27Mei09","tanggalawalpromosi" : "2009-05-27","tanggalakhirpromosi" : "2009-05-27","rnum" : 8},{"cab_namacabang" : "INDOGROSIR CIPINANG","sms_kodeigr" : "01","sms_kodemonitoring" : "2009052901","sms_namasms" : "Harga Heboh Igr Cpg 31Mei09","sms_tglawal" : "2009-05-31","sms_tglakhir" : "2009-05-31","cabang" : "01 - INDOGROSIR CIPINANG","kodemonitoring" : "2009052901","namasms" : "Harga Heboh Igr Cpg 31Mei09","tanggalawalpromosi" : "2009-05-31","tanggalakhirpromosi" : "2009-05-31","rnum" : 9},{"cab_namacabang" : "INDOGROSIR CIPINANG","sms_kodeigr" : "01","sms_kodemonitoring" : "2009060303","sms_namasms" : "Harga Hemat 24 Cpg","sms_tglawal" : "2009-06-05","sms_tglakhir" : "2009-06-11","cabang" : "01 - INDOGROSIR CIPINANG","kodemonitoring" : "2009060303","namasms" : "Harga Hemat 24 Cpg","tanggalawalpromosi" : "2009-06-05","tanggalakhirpromosi" : "2009-06-11","rnum" : 10}]';
                $result = json_decode($json_data);
            } else {
                $end_page = $request->page * 10;
                $start_page =$request->page > 1 ? $end_page - 9 :1;
                $query = $this->DB_ORACLE
                              ->table($this->DB_ORACLE->raw("tbmaster_sms"))
                              ->leftJoin($this->DB_ORACLE->raw("tbmaster_cabang"),function($join){
                                $join->on($this->DB_ORACLE->raw("sms_kodeigr") ,"=" ,$this->DB_ORACLE->raw("cab_kodecabang"));
                              })
                              ->selectRaw("
                                    cab_namacabang,
                                    sms_kodeigr,
                                    sms_kodemonitoring,
                                    sms_namasms,
                                    sms_tglawal,
                                    sms_tglakhir,
                                    sms_kodeigr || ' - ' || cab_namacabang as cabang,
                                    sms_kodemonitoring as kodemonitoring,
                                    sms_namasms as namasms,
                                    sms_tglawal as tanggalawalpromosi,
                                    sms_tglakhir as tanggalakhirpromosi,
                                    ROWNUM AS rnum
                              ")
                              ->whereRaw("ROWNUM <=".$end_page."");
                if ($request->search) {
                    $search = $request->search;
                    $query = $query->whereRaw("sms_kodemonitoring LIKE '%". $search . "%' or sms_namasms LIKE '%". $search . "%'");

                }
                 $query = $query->toSql();
                            
                $result = $this->DB_ORACLE
                               ->table($this->DB_ORACLE->raw("($query)"))
                               ->whereRaw("ROWNUM >=".$start_page."")
                               ->toSql();
                               dd($result);
               
                
            }

        return DataSMSTransformers::collection($result);

    }
    public function all_data_sms(Request $request){
        $page = $request->page?$request->page:1;
            if ($this->no_db) {
                $json_data = '[{"cab_namacabang" : "INDOGROSIR MEDAN","sms_kodeigr" : "15","sms_kodemonitoring" : "2009021701","sms_namasms" : "Harga Heboh Igr Mdn","sms_tglawal" : "2009-02-18","sms_tglakhir" : "2009-02-18","cabang" : "15 - INDOGROSIR MEDAN","kodemonitoring" : "2009021701","namasms" : "Harga Heboh Igr Mdn","tanggalawalpromosi" : "2009-02-18","tanggalakhirpromosi" : "2009-02-18","rnum" : 1},{"cab_namacabang" : "INDOGROSIR CIPINANG","sms_kodeigr" : "01","sms_kodemonitoring" : "2009022301","sms_namasms" : "Harga Hemat 10 Igr Cpg","sms_tglawal" : "2009-02-27","sms_tglakhir" : "2009-03-05","cabang" : "01 - INDOGROSIR CIPINANG","kodemonitoring" : "2009022301","namasms" : "Harga Hemat 10 Igr Cpg","tanggalawalpromosi" : "2009-02-27","tanggalakhirpromosi" : "2009-03-05","rnum" : 2},{"cab_namacabang" : "INDOGROSIR TANGERANG","sms_kodeigr" : "05","sms_kodemonitoring" : "2009040701","sms_namasms" : "Harga Hemat 16 Igr tgr","sms_tglawal" : "2009-04-10","sms_tglakhir" : "2009-04-16","cabang" : "05 - INDOGROSIR TANGERANG","kodemonitoring" : "2009040701","namasms" : "Harga Hemat 16 Igr tgr","tanggalawalpromosi" : "2009-04-10","tanggalakhirpromosi" : "2009-04-16","rnum" : 3},{"cab_namacabang" : "INDOGROSIR SURABAYA","sms_kodeigr" : "03","sms_kodemonitoring" : "2009041601","sms_namasms" : "Harga Hemat 17 Igr Sby","sms_tglawal" : "2009-04-17","sms_tglakhir" : "2009-04-23","cabang" : "03 - INDOGROSIR SURABAYA","kodemonitoring" : "2009041601","namasms" : "Harga Hemat 17 Igr Sby","tanggalawalpromosi" : "2009-04-17","tanggalakhirpromosi" : "2009-04-23","rnum" : 4},{"cab_namacabang" : "INDOGROSIR MEDAN","sms_kodeigr" : "15","sms_kodemonitoring" : "2009041602","sms_namasms" : "Harga Hemat 17 Igr Mdn","sms_tglawal" : "2009-04-17","sms_tglakhir" : "2009-04-23","cabang" : "15 - INDOGROSIR MEDAN","kodemonitoring" : "2009041602","namasms" : "Harga Hemat 17 Igr Mdn","tanggalawalpromosi" : "2009-04-17","tanggalakhirpromosi" : "2009-04-23","rnum" : 5},{"cab_namacabang" : "INDOGROSIR MEDAN","sms_kodeigr" : "15","sms_kodemonitoring" : "2009042801","sms_namasms" : "Harga Heboh Igr Mdn 29Apr09","sms_tglawal" : "2009-04-29","sms_tglakhir" : "2009-04-29","cabang" : "15 - INDOGROSIR MEDAN","kodemonitoring" : "2009042801","namasms" : "Harga Heboh Igr Mdn 29Apr09","tanggalawalpromosi" : "2009-04-29","tanggalakhirpromosi" : "2009-04-29","rnum" : 6},{"cab_namacabang" : "INDOGROSIR MEDAN","sms_kodeigr" : "15","sms_kodemonitoring" : "2009052201","sms_namasms" : "Harga Heboh Igr Mdn 25Mei09","sms_tglawal" : "2009-05-25","sms_tglakhir" : "2009-05-25","cabang" : "15 - INDOGROSIR MEDAN","kodemonitoring" : "2009052201","namasms" : "Harga Heboh Igr Mdn 25Mei09","tanggalawalpromosi" : "2009-05-25","tanggalakhirpromosi" : "2009-05-25","rnum" : 7},{"cab_namacabang" : "INDOGROSIR SURABAYA","sms_kodeigr" : "03","sms_kodemonitoring" : "2009052604","sms_namasms" : "Harga Heboh Igr Sby 27Mei09","sms_tglawal" : "2009-05-27","sms_tglakhir" : "2009-05-27","cabang" : "03 - INDOGROSIR SURABAYA","kodemonitoring" : "2009052604","namasms" : "Harga Heboh Igr Sby 27Mei09","tanggalawalpromosi" : "2009-05-27","tanggalakhirpromosi" : "2009-05-27","rnum" : 8},{"cab_namacabang" : "INDOGROSIR CIPINANG","sms_kodeigr" : "01","sms_kodemonitoring" : "2009052901","sms_namasms" : "Harga Heboh Igr Cpg 31Mei09","sms_tglawal" : "2009-05-31","sms_tglakhir" : "2009-05-31","cabang" : "01 - INDOGROSIR CIPINANG","kodemonitoring" : "2009052901","namasms" : "Harga Heboh Igr Cpg 31Mei09","tanggalawalpromosi" : "2009-05-31","tanggalakhirpromosi" : "2009-05-31","rnum" : 9},{"cab_namacabang" : "INDOGROSIR CIPINANG","sms_kodeigr" : "01","sms_kodemonitoring" : "2009060303","sms_namasms" : "Harga Hemat 24 Cpg","sms_tglawal" : "2009-06-05","sms_tglakhir" : "2009-06-11","cabang" : "01 - INDOGROSIR CIPINANG","kodemonitoring" : "2009060303","namasms" : "Harga Hemat 24 Cpg","tanggalawalpromosi" : "2009-06-05","tanggalakhirpromosi" : "2009-06-11","rnum" : 10}]';
                $result = json_decode($json_data);
            } else {
                $query = $this->DB_ORACLE
                              ->table($this->DB_ORACLE->raw("tbmaster_sms"))
                              ->leftJoin($this->DB_ORACLE->raw("tbmaster_cabang"),function($join){
                                $join->on($this->DB_ORACLE->raw("sms_kodeigr") ,"=" ,$this->DB_ORACLE->raw("cab_kodecabang"));
                              })
                              ->selectRaw("
                                    cab_namacabang,
                                    sms_kodeigr,
                                    sms_kodemonitoring,
                                    sms_namasms,
                                    sms_tglawal,
                                    sms_tglakhir,
                                    sms_kodeigr || ' - ' || cab_namacabang as cabang,
                                    sms_kodemonitoring as kodemonitoring,
                                    sms_namasms as namasms,
                                    sms_tglawal as tanggalawalpromosi,
                                    sms_tglakhir as tanggalakhirpromosi,
                                    ROWNUM AS rnum
                              ")
                              ->orderBy($this->DB_ORACLE->raw("sms_kodemonitoring"),"asc");
                if ($request->search) {
                    $search = $request->search;
                    $query = $query->whereRaw("kodemonitoring LIKE '%". $search . "%' or namasms LIKE '%". $search . "%'");

                }
                 $query = $query->toSql();
                            
                $result = $this->DB_ORACLE
                               ->table($this->DB_ORACLE->raw("($query)"))
                               ->get();
                            //    dd($result);
               
                
            }

        return DataSMSTransformers::collection($result);

    }

    public function add(Request $request){
        if ($this->no_db) {
            return response()->json(['errors'=>false,'messages'=>'Data Berhasil Ditambah'],200);
        }else{
            try {
                $this->DB_ORACLE->beginTransaction();
                     $result = $this->DB_ORACLE
                                   ->table($this->DB_ORACLE->raw("tbmaster_sms"))
                                   ->insert([
                                    "sms_kodeigr" =>$request->cabang,
                                    "sms_kodemonitoring" =>$request->kode,
                                    "sms_tglakhir" =>$request->awal_tgl,
                                    "sms_tglawal" =>$request->akhir_tgl,
                                    "sms_namasms" =>$request->nama_sms
                                   ]);
                
                $this->DB_ORACLE->commit();

                return response()->json(['errors'=>false,'messages'=>'Data Berhasil Ditambah'],200);
            } catch (\Throwable $th) {
                
                $this->DB_ORACLE->rollBack();
                // dd($th);
                return response()->json(['errors'=>true,'messages'=>$th->getMessage()],500);
            }

        }
    }
    public function update(Request $request){
        if ($this->no_db) {
            return response()->json(['errors'=>false,'messages'=>'Data Berhasil Diupdate'],200);
        }else{
            try {
                $this->DB_ORACLE->beginTransaction();
                     $result = $this->DB_ORACLE
                                   ->table($this->DB_ORACLE->raw("tbmaster_sms"))
                                   ->whereRaw("sms_kodemonitoring = '$request->kode'")
                                   ->update([
                                    "sms_kodeigr" =>$request->cabang,
                                    "sms_kodemonitoring" =>$request->kode,
                                    "sms_tglakhir" =>$request->awal_tgl,
                                    "sms_tglawal" =>$request->akhir_tgl,
                                    "sms_namasms" =>$request->nama_sms
                                   ]);
                
                $this->DB_ORACLE->commit();

                return response()->json(['errors'=>false,'messages'=>'Data Berhasil Diupdate'],200);
            } catch (\Throwable $th) {
                
                $this->DB_ORACLE->rollBack();
                // dd($th);
                return response()->json(['errors'=>true,'messages'=>$th->getMessage()],500);
            }

        }
    }
    public function remove($kode){
        if ($this->no_db) {
            return response()->json(['errors'=>false,'messages'=>'Data Berhasil Dihapus'],200);
        }else{
            try {
                $this->DB_ORACLE->beginTransaction();
                     $result = $this->DB_ORACLE
                                   ->table($this->DB_ORACLE->raw("tbmaster_sms"))
                                   ->whereRaw("sms_kodemonitoring = '$kode'")
                                   ->delete();
                
                $this->DB_ORACLE->commit();

                return response()->json(['errors'=>false,'messages'=>'Data Berhasil Dihapus'],200);
            } catch (\Throwable $th) {
                
                $this->DB_ORACLE->rollBack();
                // dd($th);
                return response()->json(['errors'=>true,'messages'=>$th->getMessage()],500);
            }

        }
    }

    public function proses_csv(Request $request){

        if ($this->no_db) {
               
            return response()->json(['errors'=>false,'messages'=>'Data CSV Berhasil Diproses'],200);
        }else{

            try {
                $this->DB_ORACLE->beginTransaction();

                if (trim($request->kode_monitoring) === "") {
                    return response()->json(['message' => 'Kode Monitoring harus dipilih'], 400);
                }
                
                if ($request->jenis_hp === "") {
                    return response()->json(['message' => 'Jenis HP harus dipilih'], 400);
                }
                //can open
                // $dtTemp = $this->DB_ORACLE
                //                ->table($this->DB_ORACLE->raw("tbmaster_sms"))
                //                ->whereRaw("sms_kodemonitoring = '$request->kode_monitoring'")
                //                ->get(); 
                $dtTemp = ['test'];
                $dataCSV = [];
                $strWhere  = "";
                $per = null;
                $cabangPrefix = $request->cabang;
                $kodeTlp = "";
                $FileName= "";
                $PathFile= "test";
                $strQuery = "";
                $columnHeader =[
                    "CUS_HPMEMBER",
                    "CUS_NAMAMEMBER",
                    "CUS_ALAMATEMAIL",
                    "CUS_KODEIGR",
                    "CUS_KODEMEMBER",
                    "SMS_KODEMONITORING"

                ];
                if (count($dtTemp) === 0) {
                    return response()->json(['message' => 'Kode Monitoring tidak terdaftar'], 400);
                }
                // ==== ???
                if ($request->member_aktif_berbelanja) {
                    if (!$request->periode) {
                        return response()->json(['message' => 'Periode harus diisi'], 400);
                    } else {
                        if (!is_numeric($request->periode)) {
                            return response()->json(['message' => 'Periode harus angka'], 400);
                        } else {
                            $per = $request->periode;
                        }
                    }
                }
                 // ==== ???


                if (in_array($cabangPrefix, ['01', '02', '05'])) {
                    $kodeTlp = "021";
                } elseif ($cabangPrefix === "03") {
                    $kodeTlp = "031";
                } elseif ($cabangPrefix === "04") {
                    $kodeTlp = "022";
                } elseif ($cabangPrefix === "06") {
                    $kodeTlp = "0274";
                } elseif ($cabangPrefix === "15") {
                    $kodeTlp = "061";
                }

                if (strtoupper($request->jenis_hp) === "GSM") {
                    $strWhere .= "AND (SUBSTR(CUS_HPMEMBER,0, 4) IN (SELECT HLR_KODEDIGIT FROM TBMASTER_HLR WHERE HLR_JENISHP = 'GSM') OR SUBSTR(CUS_HPMEMBER, 0, 3) IN (SELECT SUBSTR(HLR_KODEDIGIT, -1, 3) FROM TBMASTER_HLR WHERE HLR_JENISHP = 'GSM')) ";
                } elseif (strtoupper($request->jenis_hp) === "CDMA") {
                    $strWhere .= "AND (SUBSTR(CUS_HPMEMBER, 0, 4) NOT IN (SELECT HLR_KODEDIGIT FROM TBMASTER_HLR WHERE HLR_JENISHP = 'GSM') AND SUBSTR(CUS_HPMEMBER, 0, 3) NOT IN (SELECT SUBSTR(HLR_KODEDIGIT, -1, 3) FROM TBMASTER_HLR WHERE HLR_JENISHP = 'GSM')) ";
                }

                if ($request->cabang !== "") {
                    $strWhere .= "AND (CUS_KODEIGR = '" . $request->cabang . "' OR CUS_KODEIGR = '' OR CUS_KODEIGR = '13') ";
                }

                if (strtoupper($request->member) === "MERAH") {
                    $strWhere .= "AND CUS_FLAGMEMBERKHUSUS = 'Y' ";
                } elseif (strtoupper($request->member) === "REGULER") {
                    $strWhere .= "AND CUS_FLAGMEMBERKHUSUS <> 'Y' ";
                }

                if ($request->group !== "") {
                    if (substr($request->group, 0, 1) === " ") {
                        $strWhere .= "AND (CUS_JENISMEMBER = '-' OR CUS_JENISMEMBER IS NULL) ";
                    } else {
                        $strWhere .= "AND CUS_JENISMEMBER = '" . $request->group."' ";
                    }
                }

                if ($request->outlet !== "") {
                    $strWhere .= "AND CUS_KODEOUTLET = '" .$request->outlet. "' ";
                }

                if ($request->pkp !== "") {
                    $strWhere .= "AND CUS_FLAGPKP = '" . $request->pkp. "' ";
                }
                // if ($request->input('FolderBrowserDialog1') === "OK") {
                    if ($request->jenis_hp === "GSM") {
                        $FileName = trim($request->kode_monitoring) . "_GSM.CSV";
                    } elseif ($request->jenis_hp === "CDMA") {
                        $FileName = trim($request->kode_monitoring) . "_CDMA.CSV";
                    } else {
                        $FileName = trim($request->kode_monitoring) . ".CSV";
                    }

                    // $PathFile = $request->input('FolderBrowserDialog1');

                    // $lblPathFile = (substr($PathFile, -1) === '\\') ? $PathFile : $PathFile . '\\';
                    // $PathFile .= $FileName;
                // }

                // if (file_exists($PathFile . $FileName)) {
                //     unlink($PathFile . $FileName);
                // }
                
                // $tw = fopen($lblPathFile, 'w');
                
                if ($request->member_aktif_berbelanja) {
                
                    // if ($this->check_data_sales_exist($per)) { //can open
                    if (false) {
                        $lblRec = "Fetching sales data...";
                        // Application.DoEvents(); // This line might not be necessary in PHP
                
                        $strQuery .= "SELECT CUS_KODEIGR, CUS_KODEMEMBER, CUS_NAMAMEMBER, CUS_HPMEMBER, CUS_ALAMATEMAIL FROM ";
                        $strQuery .= "( ";
                        $strQuery .= "SELECT JH_CUS_KODEMEMBER FROM TBTR_JUALHEADER_INTERFACE@IGRCRM ";
                        $strQuery .= "WHERE JH_TRANSACTIONDATE BETWEEN ADD_MONTHS(SYSDATE, -" . $per . ") AND SYSDATE ";
                        $strQuery .= "AND JH_KODEIGR = '" . $request->cabang . "' ";
                        $strQuery .= "AND JH_CUS_KODEMEMBER IS NOT NULL ";
                        $strQuery .= "AND JH_RECORDID IS NULL ";
                        $strQuery .= "GROUP BY JH_CUS_KODEMEMBER ";
                        $strQuery .= ") LEFT JOIN TBMASTER_CUSTOMER ON CUS_KODEMEMBER = JH_CUS_KODEMEMBER ";
                    } else {
                        $strQuery .= "SELECT CUS_KODEIGR, CUS_KODEMEMBER, CUS_NAMAMEMBER, CUS_HPMEMBER ";
                        $strQuery .= "FROM TBMASTER_CUSTOMER ";
                    }
                
                    $strQuery .= "WHERE CUS_HPMEMBER <> '-' AND CUS_HPMEMBER IS NOT NULL " . $strWhere;
                } else {
                    $strQuery = "";
                    $strQuery .= "SELECT CUS_KODEIGR, CUS_KODEMEMBER, CUS_NAMAMEMBER, CUS_HPMEMBER ";
                    $strQuery .= "FROM TBMASTER_CUSTOMER ";
                    $strQuery .= "WHERE CUS_HPMEMBER <> '-' AND CUS_HPMEMBER IS NOT NULL " . $strWhere;
                }
                
                if ($request->jumlah_member !== "") {
                    $strQuery .= "AND ROWNUM <= " . $request->jumlah_member;
                }
                // $dataCSV = $this->DB_ORACLE->select($strQuery); //can open
                
                // if (count($dtCSV) !== 0) {
                //     $btnProsesEnabled = false;
                
                //     fwrite($tw, "CUS_HPMEMBER, CUS_NAMAMEMBER, CUS_ALAMATEMAIL, CUS_KODEIGR, CUS_KODEMEMBER, SMS_KODEMONITORING\n");
                
                //     // $ProgressBar2Max = count($dtCSV);
                //     // $ProgressBar2Value = 0;
                
                //     // for ($i = 0; $i < count($dtCSV); $i++) {
                //     //     $lblRec = "Record Nomor HP : " . ($i + 1) . " of " . count($dtCSV);
                //     //     // Application.DoEvents(); // This line might not be necessary in PHP
                
                //     //     fwrite($tw, "'" . $dtCSV[$i]['CUS_HPMEMBER'] . ", " . $dtCSV[$i]['CUS_NAMAMEMBER'] . ", " . $dtCSV[$i]['CUS_ALAMATEMAIL'] . ", " . $dtCSV[$i]['CUS_KODEIGR'] . ", " . $dtCSV[$i]['CUS_KODEMEMBER'] . ", " . trim($request->input('txtKdMntr')) . "\n");
                
                //     //     $ProgressBar2Value += 1;
                //     // }
                // } else {
                //     // MsgBox("Tidak ada data Member", MsgBoxStyle.Information, "Proses CSV"); // Replace this with Laravel equivalent
                //     fclose($tw);
                //     // exit(); // You might need to handle the exit differently in Laravel
                // }
                // dd($request->all());
                
                // dd($request->all());
                
                $this->DB_ORACLE->commit();
                $path = $this->make_csv($dataCSV ,$FileName,"csv/",$columnHeader);
                $download = base64_encode($path);
                // return $download;
                return response()->json(['errors'=>false,'messages'=>"Data CSV berhasil di proses",'download'=>url('/download_csv?path='.$download)],200);
            } catch (\Throwable $th) {
                
                $this->DB_ORACLE->rollBack();
                // dd($th);
                return response()->json(['errors'=>true,'messages'=>$th->getMessage()],500);
            }
            // $result = $this->DB_ORACLE
            //                ->table($this->DB_ORACLE->raw(""))
            //                ->orderBy("","asc")
            //                ->get();

        }

    }
    public function execute_download(Request $request){
        $path =base64_decode($request->path);
        return $this->download_csv($path);
    }

    public function check_data_sales_exist(Request $request){
        if ($this->no_db) {
                return false;
        }else{
            $dtSales = $this->DB_ORACLE
                           ->table($this->DB_ORACLE->raw("tbtr_jualheader_interface"))
                           ->selectRaw("COUNT(*) as count")
                           ->whereRaw(" JH_KODEIGR = '" . $request->cabang . "'")
                           ->whereRaw(" JH_TRANSACTIONDATE BETWEEN ADD_MONTHS(SYSDATE, -" . $request->periode . ") and SYSDATE")
                           ->get();

            if ($dtSales[0]->count > 0) {
                return true;
            } else {
                return false;
            }
        }

    }

}
