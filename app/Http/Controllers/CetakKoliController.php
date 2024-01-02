<?php

namespace App\Http\Controllers;

use App\Traits\LibraryPDF;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;

class CetakKoliController extends Controller
{
    use LibraryPDF;
    public $DB_PGSQL;
    public $kdigr;
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
        return view('cetak-koli.index');
    }

    public function cetak_koli(Request $request){

        $this->validate($request, [
            'nomor_terakhir' => 'required',
            'jarak_atas' => 'required',
            'jarak_kiri' => 'required',
            'jumlah_label' => 'required|min:1',
        ]);
        $ls = [];
        $errmsg = "";

        $seqLastKoli = $this->toNumberic($request->nomor_terakhir);
        $JarakAtas = $request->jarak_atas;
        $JarakKiri = $request->jarak_kiri;
        $chkAkhiranD = $request->dengan_akhiran_d?$request->dengan_akhiran_d:false;
        $chkIDM = $request->idm?$request->idm:false;
        
            $txtJumlahLabel = $request->jumlah_label;

            for ($i = (int)$seqLastKoli + 1; $i <= $txtJumlahLabel + (int)$seqLastKoli; $i += 2) {
                $to_alpha_numberic = (int)$this->to_alpha_numberic($i)[0]->dual;
                if ($i + 1 > $seqLastKoli + $txtJumlahLabel) {
                    $ls[] =  str_pad($to_alpha_numberic,($chkIDM ? 12 : 9), "0");
                } else {
                    $ls[] =  str_pad($to_alpha_numberic,($chkIDM ? 12 : 9), "0");
                    $ls[] = str_pad(($to_alpha_numberic +1),($chkIDM ? 12 : 9), "0");
                }
            }

            $sb = "select nextval('seq_nokoli')";

            for ($i = (int)$seqLastKoli + 1; $i <= $txtJumlahLabel + (int)$seqLastKoli; $i += 2) {
                if ($i + 1 > $seqLastKoli + $txtJumlahLabel) {
                    $this->DB_PGSQL->select($sb."as seq_nokoli_nextval");
                } else {
                    $this->DB_PGSQL->select($sb."as seq_nokoli_nextval");
                    $this->DB_PGSQL->select($sb."as seq_nokoli_nextval");
                }
            }

            return response()->json(['errors'=>false,'messages'=>'berhasil','download'=>url('/print/koli?koli='.base64_encode(json_encode($ls)) )],200);
        
    }

    public function cetak_koli_reprint(Request $request){
        $nomor_terakhir = $request->nomor_terakhir;
        $input1 = $request->input1;
        $input2 = $request->input2;
        $chkAkhiranD = $request->dengan_akhiran_d?$request->dengan_akhiran_d:false;
        $chkIDM = $request->idm?$request->idm:false;
        $JarakAtas = $request->jarak_atas;
        $JarakKiri = $request->jarak_kiri;
        $this->validate($request, [
            'jarak_atas' => 'required',
            'jarak_kiri' => 'required',
            'input1' => [
                'required',
                function ($attribute, $value, $fail) use($nomor_terakhir) {
                   
                    if ($value > $nomor_terakhir) {
                        $fail($attribute . ' more bigger than nomor terakhir');
                    }
                }
            ],
            'input2' => [
                'required',
                function ($attribute, $value, $fail) use($nomor_terakhir,$input2) {
                    
                    if ($value > $input2) {
                        $fail($attribute . ' more bigger than nomor terakhir');
                    }
                    if ($value > $input2) {
                        $fail($attribute . ' more bigger than input1');
                    }
                }
            ],
        ]);
        $ls = [];
        $errmsg = "";

        $seqLastKoli = $this->toNumberic($request->nomor_terakhir);
       

            for ($i = (int)$input1; $i <= $input2; $i += 2) {
                $to_alpha_numberic = (int)$this->to_alpha_numberic($i)[0]->dual;
                if ($i + 1 > $input2) {
                    $ls[] =  str_pad($to_alpha_numberic,($chkIDM ? 12 : 9), "0");
                } else {
                    $ls[] =  str_pad($to_alpha_numberic,($chkIDM ? 12 : 9), "0");
                    $ls[] = str_pad(($to_alpha_numberic +1),($chkIDM ? 12 : 9), "0");
                }
            }


            return response()->json(['errors'=>false,'messages'=>'Operation completed successfully','download'=>url('/print/koli?koli='.base64_encode(json_encode($ls)) )],200);
        
    }

    public function print_koli(Request $request){
        return $this->printPDF($request->koli,"cetak-koli.print-koli ","Cetak KOLI".date('Y-m-d H:i:s').'pdf');
    }

    public function check_plu(Request $request){
        $today = date('Y-m-d');
        try {
            $this->DB_PGSQL->beginTransaction();
            $result = $this->DB_PGSQL
                    ->table('tbmaster_prodmast')
                    ->selectRaw("prd_deskripsipendek as deskripsi,prd_prdcd as prdcd")
                    ->whereRaw("prd_prdcd like '%$request->prdcd%'")
                    ->first();
            
            $this->DB_PGSQL->commit();
            if ($result) {
                return response()->json(['errors'=>false,'messages'=>'berhasil','data'=>$result],200);
            } else {
                return response()->json(['errors'=>true,'messages'=>'Data PLU Tidak ditemukan','data'=>0],404);
            }
            
        } catch (\Throwable $th) {
            
            $this->DB_PGSQL->rollBack();
            // dd($th);
            return response()->json(['errors'=>true,'messages'=>$th->getMessage()],500);
        }
    }
    
    public function cetak_plu(Request $request){
        return response()->json(['errors'=>false,'messages'=>'berhasil','download'=>url('/print/plu?prdcd='.$request->prdcd.'&jumlah_label='.$request->jumlah_label)],200);
    }

    public function print_plu(Request $request){
        $data = [];
        for ($i=1; $i <=$request->jumlah_label ; $i++) { 
            $data[] = $request->prdcd;
        }
        return $this->printPDF($data,"cetak-koli.print-plu","reprint-checker".date('Y-m-d H:i:s').'pdf');
    }
    
    public function cetak_obi(Request $request){
        
        $this->validate($request, [
            'nomor_terakhir' => 'required',
            'jarak_atas' => 'required',
            'jarak_kiri' => 'required',
            'jumlah_label' => 'required|min:1',
        ]);
        $kdigr = session('KODECABANG'); 
        $ls = []; 
        $barcode = []; 
        $barcode_terakhir = null; 
        $NoKoli1 = ""; 
        $NoKoli2 = ""; 
        $errmsg = ""; 
        $LastNokoliOBI = $request->nomor_terakhir; 
    
        $JarakAtas = $request->jarak_atas; 
        $JarakKiri = $request->jarak_kiri;
        try {
            $this->DB_PGSQL->beginTransaction();

            $tanggal = date('d');
            $bulan = date('m');
            $tahun = date('Y');



            // if (strlen($tanggal) == 1) { 
            //     $tanggal = "0" . $tanggal; 
            // } 
     
            // if (strlen($bulan) == 1) { 
            //     $bulan = "0" . $bulan; 
            // } 

            $incr = $request->nomor_terakhir;  
            
            for ($i = (int)substr($LastNokoliOBI, -5) + 1; $i <= (int)$request->jumlah_label + (int)substr($LastNokoliOBI, -5); $i++) { 
                $incr++; 
    
                $generated = str_pad($incr, 5, '0', STR_PAD_LEFT); 
                $barcode[] =  $tanggal . $bulan . $tahun . $generated;
               $this->DB_PGSQL->table('tbmaster_obi_barcode')->insert([ 
                    'obr_recid' => null, 
                    'obr_barcode' => $tanggal . $bulan . $tahun . $generated, 
                    'obr_kodeigr' => $kdigr, 
                    'obr_create_dt' => date('Y-m-d H:i:s') 
                ]); 
            } 
            $input1 = $barcode[0];
            $input2 = $barcode[count($barcode)-1];
            for ($i = (int)substr($LastNokoliOBI, -5) + 1; $i <= (int)$request->jumlah_label + (int)substr($LastNokoliOBI, -5); $i += 2) { 
                if ($i + 1 > (int)substr($LastNokoliOBI, -5) + (int)$request->jumlah_label) { 
                    $ls[] = substr($LastNokoliOBI, 0, 8) . str_pad($i, 5, '0', STR_PAD_LEFT); 
                } else { 
                    $ls[] = substr($LastNokoliOBI, 0, 8) . str_pad($i, 5, '0', STR_PAD_LEFT); 
                    $ls[] = substr($LastNokoliOBI, 0, 8) . str_pad($i + 1, 5, '0', STR_PAD_LEFT); 
                } 
            }

            $barcode_terakhir = $this->isi_last_barcode_obi($kdigr);

            $this->DB_PGSQL->commit();

            return response()->json(['errors'=>false,'messages'=>'berhasil','barcode_terakhir'=>$barcode_terakhir,'download'=>url('/print/obi?input1='.$input1.'&input2='.$input2)],200);
        } catch (\Throwable $th) {
            
            $this->DB_PGSQL->rollBack();
            //dd($th);
            return response()->json(['errors'=>true,'messages'=>$th->getMessage()],500);
        }
    }

    public function cetak_obi_reprint(Request $request){
    
        $this->validate($request, [
            'input1' => 'required|min:13',
            'input2' => 'required|min:13',
            'jarak_atas' => 'required',
            'jarak_kiri' => 'required',
        ]);

        $ls = [];
        $errmsg = '';
        $nomor_terakhir = $request->nomor_terakhir;
        $JarakAtas = $request->jarak_atas;
        $JarakKiri = $request->jarak_kiri;
        $input1 = str_replace(' ', '', $request->input1);
        $input2 = str_replace(' ', '', $request->input2);

        for ($i = (int)substr($input1, -5); $i <= (int)substr($input2, -5); $i += 2) {
            if ($i + 1 > (int)substr($input2, -5)) {
                $ls[] = substr($nomor_terakhir, 0, 8) . str_pad($i, 5, '0', STR_PAD_LEFT);
            } else {
                $ls[] = substr($nomor_terakhir, 0, 8) . str_pad($i, 5, '0', STR_PAD_LEFT);
                $ls[] = substr($nomor_terakhir, 0, 8) . str_pad($i + 1, 5, '0', STR_PAD_LEFT);
            }
        }

        return response()->json(['errors'=>false,'messages'=>'berhasil','download'=>url('/print/obi?input1='.$input1.'&input2='.$input2)],200);

    }

    public function cek_no_reprint_obi($input1 = null, $input2 = null){
        $barcode =  $this->DB_PGSQL
                        ->table('tbmaster_obi_barcode')
                        ->selectRaw("obr_barcode as barcode")        
                        ->whereRaw("COALESCE(OBR_RECID,'0') <> '1'")
                        ->whereRaw("DATE_TRUNC('DAY', obr_create_dt) = CURRENT_DATE")
                        ->whereRaw("OBR_BARCODE BETWEEN '$input1' AND '$input2'")
                        ->orderBy("obr_barcode","asc")
                        ->get();

        return $barcode;
    }

    public function isi_last_barcode_obi($kdigr){
        $barcode =  $this->DB_PGSQL
                        ->table('tbmaster_obi_barcode')
                        ->selectRaw("COALESCE(MAX(obr_barcode), RPAD(TO_CHAR(CURRENT_DATE, 'DDMMYYYY'), 13, '0')) as barcode")        
                        ->whereRaw("obr_kodeigr = '$kdigr'")
                        ->whereRaw("DATE_TRUNC('DAY', obr_create_dt) = CURRENT_DATE")
                        ->first()->barcode;

        $txtLastNumberOBI = $barcode;
        return $txtLastNumberOBI;
    }

    public function get_last_row(){
        $today = date('Y-m-d');
        try {
            $this->DB_PGSQL->beginTransaction();
            $result = $this->DB_PGSQL
                    ->table('tbmaster_obi_barcode')
                    ->where(function ($query) use ($today) {                
                        $query->where($this->DB_PGSQL->raw("DATE_TRUNC('DAY', OBR_CREATE_DT)"), '=', $this->DB_PGSQL->raw("'$today'::date"))
                            ->orWhere($this->DB_PGSQL->raw("DATE_TRUNC('DAY', OBR_MODIFY_DT)"), '=', $this->DB_PGSQL->raw("'$today'::date"));            
                    })
                    ->orderByDesc('obr_barcode')
                    ->first();
            
            $this->DB_PGSQL->commit();
            if ($result) {
                $tmp = $result->obr_barcode;
                $last = (int)substr($tmp, -5);
                return response()->json(['errors'=>false,'messages'=>'berhasil','data'=>$last],200);
            } else {
                return response()->json(['errors'=>false,'messages'=>'berhasil','data'=>0],200);
            }
            
        } catch (\Throwable $th) {
            
            $this->DB_PGSQL->rollBack();
            // dd($th);
            return response()->json(['errors'=>true,'messages'=>$th->getMessage()],500);
        }
    }

    public function get_set_koli_omi(){
        $today = date('Y-m-d');
        try {
            $this->DB_PGSQL->beginTransaction();
            $result = $this->DB_PGSQL
                    ->table($this->DB_PGSQL->raw("seq_nokoli"))
                    ->selectRaw("last_value")
                    ->first();
            
            $this->DB_PGSQL->commit();
            if ($result) {
                $tmp = $result->last_value;
                $last = (int)$tmp;
                return response()->json(['errors'=>false,'messages'=>'berhasil','data'=>$last],200);
            } else {
                return response()->json(['errors'=>false,'messages'=>'berhasil','data'=>0],200);
            }
            
        } catch (\Throwable $th) {
            
            $this->DB_PGSQL->rollBack();
            // dd($th);
            return response()->json(['errors'=>true,'messages'=>$th->getMessage()],500);
        }
    }

    public function to_alpha_numberic($numeric = null){
        $seq = "000000000";
        $numeric = (string)$numeric;

        $query = "SELECT TO_CHAR(CURRENT_DATE,'YYMM') || '" . str_pad($numeric, 5, "0", STR_PAD_LEFT) . "' DUAL";

        $seq = $this->DB_PGSQL->select($query);

        return $seq;

    }
    
    public function toNumberic($alpha = null){
        $seq = "00000";

        $seq = substr($alpha, -5);

        return $seq;

    }
    /**
     * reprint_checker
     * 
     * function for check and print barcode nomor koli
     *
     * @param  mixed $request
     * @return void
     */
    public function reprint_checker(Request $request){
        $validated = $request->validate([
            'nomor_koli' => [
                'required',
                function ($attribute, $value, $fail) {
                    $length = strlen($value);
                    if ($length !== 6 && $length !== 12) {
                        $fail($attribute . ' must be either 6 or 12 characters.');
                    }
                },
            ],
        ]);

        try {
            $this->DB_PGSQL->beginTransaction();

            $query = $this->DB_PGSQL
                          ->table("tbtemp_print_koli")
                          ->selectRaw("count(*)")
                          ->whereRaw("prn_nokoli = '$request->nomor_koli'")
                          ->first();
                        //   dd($query);
            if ($query->count) {
                $update_data = $this->DB_PGSQL
                                    ->table("tbtemp_print_koli")
                                    ->whereRaw("prn_nokoli = '$request->nomor_koli'")
                                    ->update([
                                        "prn_recordid" => null 
                                    ]);
                $message ="Data Berhasil dicetak";
                $code =200;
            } else {
                $message ="Nomor Koli Tidak Ditemukan!";
                $code =404;
            }
            
            $this->DB_PGSQL->commit();
            return response()->json(['errors'=>false,'messages'=>$message],$code);
        } catch (\Throwable $th) {
            
            $this->DB_PGSQL->rollBack();
            // dd($th);
            return response()->json(['errors'=>true,'messages'=>$th->getMessage()],500);
        }
    }

    public function print_obi(Request $request){
        $data = $this->cek_no_reprint_obi($request->input1,$request->input2);
        return $this->printPDF($data,"cetak-koli.print-obi","print-obi ".date('Y-m-d H:i:s').'pdf');
    }
    public function print_reprint_checker(Request $request){
        return $this->printPDF($request->nomor_koli,"cetak-koli.print-reprint-checker ","reprint-checker".date('Y-m-d H:i:s').'pdf');
    }

}
