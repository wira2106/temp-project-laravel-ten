<?php

namespace App\Http\Controllers;

use App\Traits\LibraryCSV;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Mail;

class AlokasiController extends Controller
{
    use LibraryCSV;
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
        return view('alokasi.seasonal.index');
    }
    public function index_khusus(){
        return view('alokasi.khusus.index');
    }
    /**
     * Alokasi Seasonal
     *
     * 
     */
    public function insert_bulk_ora($table = null,$data){
            try {
                $this->DB_PGSQL->beginTransaction();
                $this->DB_PGSQL->table($table)->insert($data);
                
                $this->DB_PGSQL->commit();
                return true;
            } catch (\Throwable $th) {
                
                $this->DB_PGSQL->rollBack();
                // dd($th);
                return false;
            }
    }

    public function kirim_pb_seasonal(Request $request){
        $kdSeasonal = $request->kode_seasonal;
        $periode = explode("-", $request->periode);
        $awal = str_replace(" ","",$periode[0]);
        $awal = str_replace("/","-",$periode[0]);
        $akhir = str_replace(" ","",$periode[1]);
        $akhir = str_replace("/","-",$periode[1]);
        $tglAwal = date('Y-m-d',strtotime($awal));
        $tglAkhir = date('Y-m-d',strtotime($akhir));

        $toko = $request->toko;
        $omi = $request->omi;
        $omi = $toko . " - " . $omi;
        $tglJT = date('Y-m-d',strtotime($request->jatuh_tempo));
        $list_plu = json_decode($request->plu);
        $pb = [];

        try {
            $this->DB_PGSQL->beginTransaction();

            if (!count($list_plu)) {
                return response()->json(['errors'=>true,'messages'=>'Tidak Ada PLU Yang Dipilih.'],422);
            }
            if (!$toko) {
                return response()->json(['errors'=>true,'messages'=>'Data Tidak Lengkap.'],422);
            }
            
            if (date('Y-m-d') > $tglJT) {
                return response()->json(['errors'=>true,'messages'=>'Sudah Lewat Tanggal Jatuh Tempo.'],422);
            }
            foreach ($list_plu as $row) {
                if ($row->qty > 0) {
                    $plu = $row->plu;
                    $qty = (int)$row->qty;
            
                    $pb []= [
                        'kodeseasonal' => $kdSeasonal,
                        'tglawal' => $tglAwal,
                        'tglakhir' => $tglAkhir,
                        'kodetoko' => $toko,
                        'tgljt' => $tglJT,
                        'prdcd' => $plu,
                        'qtyo' => $qty
                    ];
                }
            }

            $this->DB_PGSQL->table("temp_omi_pb")->delete();
            // Use your actual method or logic to perform the bulk insert
            if (!$this->insert_bulk_ora('temp_omi_pb', $pb)) {
                    // return response()->json(['errors'=>true,'messages'=>'Error Input PLU Seasonal.'],500);
            }

            $noPB = $this->DB_PGSQL->select("SELECT 'DS' || to_char(current_date, 'YY') || lpad(nextval('seq_alokasi')::text, 6, '0') as noPB");
            $noPB = $noPB[0]->nopb;


            $data_insert = $this->DB_PGSQL
                                ->table("temp_omi_pb")
                                ->leftJoin("tbmaster_prodmast_omi",function($join){
                                    $join->on("pro_kodetoko" ,"=" ,"kodetoko")
                                        ->on("pro_prdcd" ,"=" ,"prdcd");
                                })
                                ->selectRaw("
                                    kodeseasonal,
                                    tglawal::date,
                                    tglakhir::date,
                                    kodetoko,
                                    '$noPB',
                                    current_date,
                                    tgljt::date,
                                    prdcd,
                                    pro_singkatan,
                                    qtyo,
                                    current_date
                                ");
            $insert_using = $this->DB_PGSQL
                                 ->table("pb_seasonal_omi")
                                 ->insertUsing(["pso_kodeseasonal","pso_tglawal","pso_tglakhir","pso_kodetoko","pso_nopb","pso_tglpb","pso_tgljt","pso_prdcd","pso_deskripsi","pso_qtyo","pso_create_dt"],$data_insert);
            
            $path = $this->make_csv($datas = $pb,"DS".$toko. date('ymd').".CSV","csv/", ['kodeseasonal','tglawal','tglakhir','kodetoko','tgljt','prdcd','qtyo',]);
            $this->send_email($path,$toko,$noPB,count($pb));
           
            $this->DB_PGSQL->commit();
            return response()->json(['errors'=>false,'messages'=>"Berhasil Di kirim"],200);
        } catch (\Throwable $th) {
            
            $this->DB_PGSQL->rollBack();
            // dd($th);
            return response()->json(['errors'=>true,'messages'=>$th->getMessage()],500);
        }
    }
    public function get_mail(){
        $data_email = $this->DB_PGSQL
                            ->table("master_email_cabang")
                            ->selectRaw("
                                mec_mail_server as server, 
                                mec_mail_port as port, 
                                mec_mail_user as uuser, 
                                mec_mail_pass as pass, 
                                mec_to as too, 
                                mec_cc as cc, 
                                mec_subject as subject
                            ")
                            ->first();
        return $data_email;
    }
    public function send_email($path,$toko,$noPB,$jmlitem){
        $data_email = $this->get_mail();
        $to = explode(",",$data_email->too);
        $cc = explode(",",$data_email->cc);
        $subject = $data_email->subject;
        $data = [
            "toko" =>$toko,
            "noPB" =>$noPB,
            "jmlitem" =>$jmlitem,
            "to" =>$to
        ];
        $FileName = $path;
        Mail::send('alokasi.seasonal.mail', $data, function ($message) use ($FileName, $subject, $to,$cc) {
            $message->from(config('mail.from.address'))
            // $message->from('noreply.sd1@indogrosir.co.id')
                ->to($to)
                ->cc($cc)
                ->subject($subject)
                ->attach($FileName);
        });
    }
    public function alokasi_seasonal_load(){

            // GET PLU DULU
            $this->get_data_dt9();

            // LOAD DATA (KALAU ADA)
            $count = $this->DB_PGSQL
                         ->table("alokasi_seasonal_omi")
                         ->selectRaw("COUNT(1) as count")
                         ->get();
            $count = $count[0]->count;
            

            if ($count > 0) {
                $this->get_deskripsi();

                // $first = true;
                $kode = $this->load_seasonal();

                // $cbKodeEnabled = true;
                // $btnCreateEnabled = true;

                return response()->json(['errors'=>false,'messages'=>"berhasil",'kode' =>$kode],200);
            } else {
                echo "Belum Ada Alokasi Seasonal !";
               
                return response()->json(['errors'=>true,'messages'=>"Belum Ada Alokasi Seasonal !"],404);
            }

    }
    public function get_data_dt9(){
        $dt9 = $this->DB_PGSQL
                    ->table("tbmaster_prodmast_omi")
                    ->selectRaw("
                        COUNT(1) as count
                    ")
                    ->whereRaw("pro_create_dt::date = current_date")
                    ->get();

                    
        if((int)$dt9[0]->count){
            $message = "Berhasil";
            $error = false;
            $code = 200;
        }else{
            $message = "Data Tidak Ada";
            $error = true;
            $code = 404;
        }

        // return response()->json(['errors'=>$error,'messages'=>$message,'dt9' => $dt9],$code);            
        return $dt9;            
    }

    // public function get_data_seasonal(Request $request){
    //     $fileSeasonal = "OMI" . now()->format('Y') . $kdIGR . ".CSV";
    //     $pathLocal = 'your_local_path'; // Replace with your actual local path
        
    //     $dtSeasonal = collect([
    //         ['kodeseasonal', 'tglawal', 'tglakhir', 'kodetoko', 'tgljt', 'prdcd', 'qty']
    //     ]);
        
    //     // DOWNLOAD DULU CSV DARI FTP
    //     if (!downloadFTP($pathLocal, $fileSeasonal, "SEASONAL", 19)) {
    //         exit;
    //     }
        
    //     // READ CSV
    //     $fullPath = $pathLocal . '/' . $fileSeasonal;
    //     try {
    //         $dtSeasonal = readCSV($fullPath);
    //     } catch (Exception $ex) {
    //         $message = "File " . $fileSeasonal . " Gagal Dibaca";
    //         $error = true;
    //         $code = 422;
            
    //         return response()->json(['errors'=>$error,'messages'=>$message],$code); 
    //     }
        
    //     // CEK CEK AGAIN
    //     if (count($dtSeasonal)) {
    //         DB::table('temp_alokasi_seasonal_omi')->delete();
        
    //         if (!insertBulkOra('temp_alokasi_seasonal_omi', $dtSeasonal)) {
    //             echo "File " . $fileSeasonal . " Tidak Dapat Disimpan";
    //             exit;
    //         }
        
    //         // INSERT DATA ITEM KE ALOKASI SEASONAL
    //         $this->DB_PGSQL->statement("
    //             MERGE INTO alokasi_seasonal_omi t
    //             USING temp_alokasi_seasonal_omi s
    //             ON (
    //                 t.aso_kodeseasonal = s.kodeseasonal
    //                 AND t.aso_kodetoko = s.kodetoko
    //                 AND t.aso_prdcd = s.prdcd
    //             )
    //             WHEN MATCHED THEN
    //                 UPDATE SET t.aso_tglawal = TO_DATE(s.tglawal, 'DD-MM-YYYY'),
    //                            t.aso_tglakhir = TO_DATE(s.tglakhir, 'DD-MM-YYYY'),
    //                            t.aso_qtyo = s.qty,
    //                            t.aso_create_dt = SYSDATE
    //             WHEN NOT MATCHED THEN
    //                 INSERT (
    //                     t.aso_kodeseasonal,
    //                     t.aso_tglawal,
    //                     t.aso_tglakhir,
    //                     t.aso_kodetoko,
    //                     t.aso_tgljt,
    //                     t.aso_prdcd,
    //                     t.aso_qtyo,
    //                     t.aso_create_dt
    //                 ) VALUES (
    //                     s.kodeseasonal,
    //                     TO_DATE(s.tglawal, 'DD-MM-YYYY'),
    //                     TO_DATE(s.tglakhir, 'DD-MM-YYYY'),
    //                     s.kodetoko,
    //                     TO_DATE(s.tgljt, 'DD-MM-YYYY'),
    //                     s.prdcd,
    //                     s.qty,
    //                     SYSDATE
    //                 )
    //         ");
        
    //         // UPDATE JATUH TEMPO
    //         $this->DB_PGSQL->statement("
    //             MERGE INTO alokasi_seasonal_omi t
    //             USING (
    //                 SELECT kodeseasonal, kodetoko, tgljt, COUNT(1) 
    //                 FROM temp_alokasi_seasonal_omi 
    //                 GROUP BY kodeseasonal, kodetoko, tgljt
    //             ) s
    //             ON (
    //                 t.aso_kodeseasonal = s.kodeseasonal
    //                 AND t.aso_kodetoko = s.kodetoko
    //             )
    //             WHEN MATCHED THEN
    //                 UPDATE SET t.aso_tgljt = TO_DATE(s.tgljt, 'DD-MM-YYYY')
    //         ");
    //     } else {

    //         $message = "File " . $fileSeasonal . " Gagal Dibaca";
    //         $error = true;
    //         $code = 422;
            
    //         return response()->json(['errors'=>$error,'messages'=>$message],$code); 
    //     }

                    
    //     if((int)$dt9[0]->count){
    //         $message = "Berhasil";
    //         $error = false;
    //         $code = 200;
    //     }else{
    //         $message = "Data Tidak Ada";
    //         $error = true;
    //         $code = 404;
    //     }

    //     return response()->json(['errors'=>$error,'messages'=>$message,'dt9' => $dt9],$code);            
    // }

    public function get_deskripsi(){
        $countQuery =$this->DB_PGSQL
                          ->table("alokasi_seasonal_omi")
                          ->selectRaw("COUNT(1) as count")
                          ->whereRaw("aso_deskripsi IS NULL  OR COALESCE(aso_modify_dt, current_date - INTERVAL '1 DAY') < current_date")
                          ->get();
        $countQuery = $countQuery[0]->count;
                          

            if ($countQuery) {
                // Query to perform the UPDATE using MERGE
                $mergeQuery = "
                    MERGE INTO alokasi_seasonal_omi 
                    USING tbmaster_prodmast_omi 
                    ON (
                        alokasi_seasonal_omi.aso_kodetoko = tbmaster_prodmast_omi.pro_kodetoko
                        AND alokasi_seasonal_omi.aso_prdcd = tbmaster_prodmast_omi.pro_prdcd
                    )
                    WHEN MATCHED THEN
                        UPDATE SET aso_deskripsi = tbmaster_prodmast_omi.pro_singkatan,
                                aso_modify_dt = current_date
                ";

                $this->DB_PGSQL->statement($mergeQuery);
            }
    }

    public function load_seasonal(){
        $kode = $this->DB_PGSQL
                    ->table("alokasi_seasonal_omi")
                    ->selectRaw("
                        DISTINCT aso_kodeseasonal as kode,
                        CONCAT(TO_CHAR(aso_tglawal, 'DD/MM/YYYY'), ' - ', TO_CHAR(aso_tglakhir, 'DD/MM/YYYY')) as periode
                    ")
                    ->get();

        if(count($kode)){
            $message = "Berhasil";
            $error = false;
            $code = 200;
        }else{
            $message = "Data Tidak Ada";
            $error = true;
            $code = 404;
        }
        return $kode;
        // return response()->json(['errors'=>$error,'messages'=>$message,'kode' => $kode],$code);            
               
        
    }
    public function load_toko(Request $request){

       $kdSeasonal = $request->kode;

       $toko = $this->DB_PGSQL
                    ->table("alokasi_seasonal_omi")
                    ->join("tbmaster_tokoigr",function($join){
                        $join->on("aso_kodetoko" ,"=" ,"tko_kodeomi");
                    })
                    ->selectRaw("
                        DISTINCT aso_kodetoko as OMI,
                        tko_namaomi as NAMA_OMI,
                        TO_CHAR(aso_tgljt, 'DD-MM-YYYY') as JATUH_TEMPO
                    ")
                    ->whereRaw("aso_kodeseasonal = '$kdSeasonal' ")
                    ->orderBy("aso_kodetoko","asc")
                    ->get();

        if(count($toko)){
            $message = "Berhasil";
            $error = false;
            $code = 200;
        }else{
            $message = "Data Tidak Ada";
            $error = true;
            $code = 201;
        }

        return response()->json(['errors'=>$error,'messages'=>$message,'toko' => $toko],$code);            
    }
    public function load_plu(Request $request){
       
        $kdSeasonal = $request->kode;
        $toko = $request->toko;

        $plu = $this->DB_PGSQL
                    ->table("alokasi_seasonal_omi")
                    ->join("tbmaster_prodmast_omi",function($join){
                        $join->on("pro_prdcd" ,"=" ,"aso_prdcd")
                             ->on("pro_kodetoko" ,"=" ,"aso_kodetoko");
                    })
                    ->selectRaw("
                        aso_prdcd as plu,
                        CASE WHEN pro_tag IN ('H','A','N','O','X','T')
                            THEN 'PLU TAG HANOXT'
                            ELSE COALESCE(aso_deskripsi, 'PLU TIDAK ADA DI MODIS')
                        END as deskripsi,
                        aso_qtyo as QTY_Alokasi,
                        COALESCE(aso_qtyr, 0) as QTY_Pemenuhan,
                        (aso_qtyo - COALESCE(aso_qtyr, 0)) as QTY,
                        CASE WHEN pro_tag IN ('H','A','N','O','X','T') OR aso_deskripsi IS NULL
                            THEN 0
                            ELSE 1
                        END as OK
                    ")
                    ->whereRaw("aso_kodeseasonal = '$kdSeasonal' ")
                    ->whereRaw("aso_kodetoko = '$toko' ")
                    ->whereRaw("aso_qtyo > COALESCE(aso_qtyr, 0)")
                    ->orderBy("aso_prdcd","asc")
                    ->get();

        // if ($this->masih_ada_pb($toko,$kdSeasonal)) {     
            if(count($plu)){
                $message = "Berhasil";
                $error = false;
                $code = 200;
            }else{
                $message = "Data Tidak Ada";
                $error = true;
                $code = 201;
            }
        // } else {
        //     $message = "PB Seasonal ".$toko." Belum Proses SPH";
        //     $error = true;
        //     $code = 201;
        // }
        

        return response()->json(['errors'=>$error,'messages'=>$message,'plu' => $plu],$code);            
    }

    public function masih_ada_pb($toko = null, $kdSeasonal = null){

        $check_pb = $this->DB_PGSQL
                     ->table("pb_seasonal_omi")
                     ->selectRaw("
                        COUNT(1) as count
                     ")
                     ->whereRaw("pso_kodeseasonal = '$kdSeasonal' ")
                     ->whereRaw("pso_kodetoko = '$toko' ")
                     ->whereRaw("pso_qtyr IS NULL")
                     ->get();
 
         if((int)$check_pb[0]->count){
             $response = true;
         }else{
             $response = false;
         }
 
         return $response;            
    
    }
    /**
     * End Alokasi Seasonal
     *
     * 
     */
    /**
     *  Alokasi Khusus
     *
     * 
     */
    public function alokasi_khusus_load(){

        $this->get_data_dt9();

        $toko =$this->DB_PGSQL
                        ->table("tbmaster_tokoigr")
                        ->selectRaw("
                            tko_kodeomi as kode,
                            tko_namaomi as nama
                        ")
                        ->whereRaw("tko_kodesbu = 'O'")
                        ->whereRaw("coalesce(tko_tgltutup, current_date+1) > current_date ")
                        ->orderBy("tko_kodeomi","asc")
                        ->get();

        if (count($toko)) {

            return response()->json(['errors'=>false,'messages'=>"berhasil",'toko' =>$toko],200);
        } else {
           
            return response()->json(['errors'=>true,'messages'=>"Data Toko Tidak tersedia !"],500);
        }

    }
    public function get_list_plu(Request $request){
        $toko = $request->toko;
        $plu = $this->DB_PGSQL->table('tbmaster_prodmast_omi')
            ->select('pro_prdcd as plu', 'pro_singkatan as deskripsi', 'pro_minor as minor')
            ->where('pro_kodetoko', $toko)
            ->whereNotIn('pro_tag', ['H', 'A', 'N', 'O', 'X', 'T'])
            ->where('pro_minor', '>', 0)
            ->orderBy('pro_prdcd', 'asc')
            ->get();

        if (count($plu)) {

            return response()->json(['errors'=>false,'messages'=>"berhasil",'plu' =>$plu],200);
        } else {
           
            return response()->json(['errors'=>true,'messages'=>"Data Toko Tidak tersedia !"],500);
        }

    }
    public function get_data_csv($noPB){
        $array_data = []; 
        $data = $this->DB_PGSQL->table('alokasi_khusus_omi')
            ->selectRaw("
                AKO_KODE as TOKO,
                AKO_NOPB as NOPB,
                TO_CHAR(AKO_TGLPB,'DD-MM-YYYY') as TGLPB,
                AKO_PRDCD as PRDCD,
                AKO_QTY as QTYO
            ")
            ->whereRaw("AKO_NOPB = '$noPB'")
            ->whereRaw("AKO_TGLPB::date = current_date")
            ->orderBy('ako_prdcd', 'asc')
            ->get();
        foreach ($data as $key => $value) {
           $array_data[] = (array)$value;
        }
       return $array_data;

    }

    public function kirim_pb_khusus(Request $request){
        
        $toko = $request->kode_toko;
        $omi = $toko . " - " .$request->omi;
        $plu = json_decode($request->plu);
        $data_insert = [];
        
        foreach ($plu as $key => $value) {
            $data_insert[] =[
                'kode' => $toko,
                'prdcd' => $value->plu,
                'qty' => $value->qty,
            ];
        }

        try {
            $this->DB_PGSQL->beginTransaction();
            
            if ( empty($toko) || empty($omi)) {
                return response()->json(['errors'=>true,'messages'=>"Data Tidak Lengkap !"],500);
            }
            // Insert bulk records into TEMP_OMI_KHUSUS
           $this->DB_PGSQL->table('temp_omi_khusus')->delete(); // DELETE FROM temp_omi_khusus
           $this->DB_PGSQL->table('temp_omi_khusus')->insert($data_insert);
    
            //    get no PB
            $noPB = $this->DB_PGSQL->select("SELECT 'DK' || to_char(current_date, 'YY') || lpad(nextval('seq_alokasi')::text, 6, '0') as noPB");
            $noPB = $noPB[0]->nopb;
            $select_insert =  $this->DB_PGSQL
                                   ->table("temp_omi_khusus")
                                   ->leftJoin("tbmaster_prodmast_omi",function($join){
                                        $join->on("pro_kodetoko" ,"=" ,"kode")
                                             ->on("pro_prdcd" ,"=" ,"prdcd");
                                    })
                                    ->selectRaw("
                                    kode, 
                                    '$noPB', 
                                    current_date, 
                                    prdcd, 
                                    pro_singkatan, 
                                    pro_minor, 
                                    qty, 
                                    current_date
                                    ");
            $insert_using =  $this->DB_PGSQL
                                  ->table("alokasi_khusus_omi")
                                  ->insertUsing(["ako_kode","ako_nopb","ako_tglpb","ako_prdcd","ako_deskripsi","ako_minor","ako_qty","ako_create_dt"],$select_insert);
            $datas = $this->get_data_csv($noPB);
            $path = $this->make_csv($datas,"DK".$toko. date('ymd').".CSV","csv/", ['toko','nopb','tglpb','prdcd','qtyo']);
            $this->send_email($path,$toko,$noPB,count($datas));
            
            $this->DB_PGSQL->commit();
            return response()->json(['errors'=>false,'messages'=>'Berhasil'],200);
        } catch (\Throwable $th) {
            
            $this->DB_PGSQL->rollBack();
            // dd($th);
            return response()->json(['errors'=>true,'messages'=>$th->getMessage()],500);
        }

    }
    
    /**
     *  End Alokasi Khusus
     *
     * 
     */
}
