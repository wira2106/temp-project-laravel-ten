<?php

namespace App\Http\Controllers;

use App\Traits\LibraryPDF;
use App\Transformers\DataMasterProdukTransformers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DB;

class LabelController extends Controller
{
    use LibraryPDF;
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

    public function insert_by_plu(Request $request){
            $ipAddress = $request->getClientIp();
            // Get the local IP address
            $hostName = gethostname();
            $ss = gethostbyname($hostName);

            $IPlocal = str_replace('.', '', $ipAddress);
            dd($ipAddress,$hostName,$ss,$IPlocal);
            // Remove dots from the IP address

            // // Function to get IP address
            // function getIPAddress()
            // {
            //     global $ipAddress;
            //     return $ipAddress;
            // }

            // // Set IP local variable
            // IPlocal = getIPAddress();
            $ipx = $request->getClientIp();

            // if (empty($request->input('txtPRDCD1'))) {
            //     return response()->json(['message' => 'PRDCD harus diisi'], 400);
            // }

            // if ((int)$request->input('txtQty') === 0) {
            //     return response()->json(['message' => 'Qty tidak boleh nol'], 400);
            // }

            // $prdcod = substr('10000000' + (int)$request->input('txtPRDCD1'), -7, 6);

            // $dobel = (int)$request->input('txtQty') > 1;

            // // Assuming FrmWait is a modal, you may not need this isn Laravel
            // // FrmWait::show();

            // // Assuming prosesPRDCD is a function to process PRDCD
            // prosesPRDCD($prdcod . '0', $request->input('txtDesc1'), (int)$request->input('txtQty'), 'Manual');

            // // Delete records from tbLabel and tbLabel_Detail
            //  $this->DB_PGSQL->table('tblabel')->delete();
            //  $this->DB_PGSQL->table('tblabel_detail')->delete();

            // // Select records from tbLabel_Detail_Master
            // $dtabOra2 =  $this->DB_PGSQL->table('tblabel_detail_master')
            //     ->where('ipadd', str_replace('.', '', $IPlocal))
            //     ->orderBy('tglInsert')
            //     ->get();

            // GridLabel::setSource($dtabOra2);
            // GridLabel::setAutoSizeColumnsMode('AllCells');

            // if (count($dtabOra2) === 0) {
            //     btnView::setEnabled(false);
            // } else {
            //     btnView::setEnabled(true);
            //     btnDeleteAll::setEnabled(true);
            // }

            // lblRec::setText(count($dtabOra2) . ' Record');

            // // Assuming FrmWait is a modal, you may not need this in Laravel
            // // FrmWait::close();


    }

    public function proses_prdcd(){

        for ($f = 0; $f < 4; $f++) {
            $price_promo[$f] = 0;
        }

        $flag = "";
        for ($i = 0; $i < 5; $i++) {
            $price_a[$i] = 0;
            $price_all[$i] = 0;
            $price_unit[$i] = 0;
            $unit[$i] = "";
            $jmlL[$i] = "";
            $barc[$i] = "";
        }

        $klik = false;
        $flag = "";

        if ($tipe == "Manual") {
            $memUnit = $memPRDCD = $memDiv = $memDept = $memKatb = "";
            $z = 0;
            $keluar = false;

            $sb = [];
            $sb[] = "Select";
            $sb[] = "	PRD_PRDCD AS PRDCD,";
            $sb[] = "	NVL(PRD_KodeTag,' ') as PTAG,";
            $sb[] = "	PRD_Unit AS UNIT,";
            $sb[] = "	PRD_KodeDivisi AS \"DIV\",";
            $sb[] = "	PRD_KodeDepartement AS DEPT,";
            $sb[] = "	PRD_KodeKategoriBarang AS KATB,";
            $sb[] = "	PRMD_HrgJual AS FMJUAL,";
            $sb[] = "	PRD_HrgJual As PRICE_A";
            $sb[] = "From TBTR_PROMOMD,TBMASTER_PRODMAST";
            $sb[] = "Where";
            $sb[] = "	TRUNC(PRMD_TglAkhir) >= TRUNC('".date('Y-m-d')."') AND";
            $sb[] = "	TRUNC(PRMD_TglAwal) <= TRUNC('".date('Y-m-d')."') AND";
            $sb[] = "	PRD_PRDCD (+) = PRMD_PRDCD and";
            $sb[] = "	SUBSTR(PRMD_PRDCD,1,6)='" . substr($txtPRDCD, 0, 6) . "'";
            
            $result = DB::select(implode(' ', $sb));

            if (count($result) == 0) {
                if ($dtKeluarPromo == "") {
                    $dtKeluarPromo = "* " . $txtPRDCD . " - " . $txtDesc . " (Tidak Terdaftar Di TBTR_PROMOMD)";
                } else {
                    $dtKeluarPromo .= "\n* " . $txtPRDCD . " - " . $txtDesc . " (Tidak Terdaftar Di TBTR_PROMOMD)";
                }
            } else {
                // ... (rest of the logic)
            }
        }

    }

    public function cetak(){
        return view('template-print.print');
        // return $this->printPDF();
    }
}
