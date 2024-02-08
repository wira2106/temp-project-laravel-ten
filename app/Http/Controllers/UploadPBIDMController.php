<?php

namespace App\Http\Controllers;

use App\Traits\LibraryCSV;
use App\Transformers\DataZonaTransformers;
use DB;

use Illuminate\Http\Request;

class UploadPBIDMController extends Controller
{
    use LibraryCSV;
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
        return view('upload-pb-idm.page.index');
    }
    public function tarik_data_csv(Request $request){
        $file = $request->file;
        $path = $file?$file->path():null;
        $filename = $file?$file->getClientOriginalName():null;
        $ipAddress = $request->getClientIp();
        $UserID = session('userid');
        $lineNumber = 1;
        $lastPLU = '';
        $noUrut = 1;
        $data_insert_majalah2 = [];
        // dd($filename);
        try {
            $this->DB_PGSQL->beginTransaction();
            
            if(!$request->file){
                return response()->json(['errors'=>true,'messages'=>"Data CSV is not found !"],422);
            }

            $csv_array = $this->csv_to_array($file);
            
            if(!count($csv_array)){
                return response()->json(['errors'=>true,'messages'=>"Data CSV Kosong !"],422);
            }
            $key_array = [];

            /**
             * checking index
             */

            foreach ($csv_array[0] as $key => $value) {
                $key_array[] = $key;
            }
            $index0 = isset($key_array[0])?$key_array[0]:null;
            $index1 = isset($key_array[1])?$key_array[1]:null;
            $index2 = isset($key_array[2])?$key_array[2]:null;
            $index3 = isset($key_array[3])?$key_array[3]:null;
            $index4 = isset($key_array[4])?$key_array[4]:null;

            $noUrut = 1;
            $lineNumber = 1;
            foreach ($csv_array as $key => $value) {
                $KodeToko = $index0? $value[$index0]:null;
                $noPB = $index1? $value[$index1]:null;
                $tglPB = $index2? $value[$index2]:null;
                $lastPLU = $index3? $value[$index3]:null;


                if (!$tglPB) {
                    // Handle invalid date
                    return response()->json(['errors'=>true,'messages'=>"Format tanggal salah, harap check kembali file CSV anda!"],422);
                }
                if (!$lastPLU) {
                    // Handle invalid plu
                    return response()->json(['errors'=>true,'messages'=>"Data PLU tidak ditemukan, harap check kembali file CSV anda!"],422);
                }
                // if ($lastPLU !== $arr[3]) {
                //     $noUrut = 1;
                //     $lastPLU = $arr[3];
                // } else {
                //     $noUrut++;
                // }

                $data_insert_majalah2 = [
                    'cpm_kodetoko' =>$index0? $value[$index0]:null,
                    'cpm_nopb' =>$index1? $value[$index1]:null,
                    'cpm_tglpb' =>$index2? $value[$index2]:null,
                    'cpm_pluidm' =>$index3? $value[$index3]:null,
                    'cpm_qty' =>$index4? $value[$index4]:null,
                    'cpm_ip' => $ipAddress,
                    'cpm_filename' => $filename,
                    'cpm_tglproses' => date('Y-m-d H:i:s'),
                    'cpm_flag' => '',
                    'cpm_create_by' => $UserID,
                    'cpm_nourut' => $noUrut,
                ];

                $noUrut++;
                $lineNumber++;
                
                $this->DB_PGSQL
                     ->table('csv_pb_majalah2')
                     ->whereRaw("CPM_IP = '$ipAddress'")
                     ->whereRaw("DATE_TRUNC('day', CPM_TGLPROSES) < DATE_TRUNC('day', CURRENT_DATE)")
                     ->delete();
                $this->DB_PGSQL
                     ->table('csv_pb_majalah2')
                     ->whereRaw("CPM_IP = '{$ipAddress}'")
                     ->whereRaw("DATE_TRUNC('day', CPM_TGLPROSES) = DATE_TRUNC('day', CURRENT_DATE)")
                     ->whereRaw("CPM_NoPB = '{$noPB}'")
                     ->whereRaw("CPM_TglPB = TO_DATE('{$tglPB}', 'DD-MM-YYYY')")
                     ->delete();
                $this->DB_PGSQL
                     ->table('csv_pb_majalah')
                     ->whereRaw("CPM_IP = '{$ipAddress}'")
                     ->whereRaw("DATE_TRUNC('day', CPM_TGLPROSES) = DATE_TRUNC('day', CURRENT_DATE)")
                     ->whereRaw("CPM_NoPB = '{$noPB}'")
                     ->whereRaw("TO_CHAR(CPM_TglPB, 'DD-MM-YYYY') = '{$tglPB}'")
                     ->delete();

                
                /**
                 * insert to csv_pb_majalah2
                 */
                $this->DB_PGSQL->table('csv_pb_majalah2')->insert($data_insert_majalah2);


                $query_exists = $this->DB_PGSQL
                     ->table("tbmaster_pbomi")
                     ->selectRaw("pbo_nopb")
                     ->whereRaw("PBO_NOPB = CPM_NoPB ")
                     ->whereRaw("PBO_KODEOMI = CPM_KodeToko ")
                     ->whereRaw("DATE_TRUNC('day',PBO_TGLPB) = DATE_TRUNC('day',CPM_TglPB) ")
                     ->whereRaw("CPM_NoPB ='$noPB'")
                     ->whereRaw("To_Char(CPM_TglPB,'DD-MM-YYYY')='$tglPB'")
                     ->toSql();
                $jum = $this->DB_PGSQL
                     ->table("csv_pb_majalah2")
                     ->selectRaw("coalesce(count(DISTINCT cpm_nopb),0)")
                     ->whereRaw("EXISTS($query_exists)")
                     ->whereRaw("cpm_kodetoko = '$KodeToko' ")
                     ->whereRaw("cpm_nopb ='$noPB'")
                     ->whereRaw("to_char(cpm_tglpb,'DD-MM-YYYY')='$tglPB'")
                     ->get();

                if (count($jum) > 0) {
                    // Handle invalid plu
                    return response()->json(['errors'=>true,'messages'=>"No Dokumen: ($noPB) Tanggal: ($tglPB) File: {$filename} SUDAH PERNAH DIPROSES!!!"],422);
                }

                $dtPLUDobel = $this->DB_PGSQL->table('csv_pb_majalah2')
                    ->selectRaw("cpm_pluidm,COALESCE(COUNT(cpm_kodetoko), 0) as count")
                    ->whereRaw("cpm_ip = '$ipAddress'")
                    ->whereRaw("cpm_nopb = '$noPB'")
                    ->whereRaw("cpm_tglpb = TO_DATE('$tglPB', 'DD-MM-YYYY')")
                    ->groupBy('cpm_pluidm')
                    ->havingRaw('COUNT(cpm_kodetoko) > 1')
                    ->get();
    
                if (count($dtPLUDobel) > 0) {
                    $listPLU ="";
                    foreach ($dtPLUDobel as $key => $value) {
                        $listPLU.= $listPLU.$value->cpm_pluidm." ";
                    }
    
                    return response()->json(['errors'=>true,'messages'=>"PLU ($listPLU) Dobel Di File ($filename) Yang Sedang Diproses, Harap Minta Revisi File PBSL Ke IDM !"],422);
    
                }

    
                // Select all data from CSV_PB_MAJALAH2

                $dtTempPBIDM2 = $this->DB_PGSQL->table('csv_pb_majalah2')
                    ->whereRaw("cpm_ip = '$ipAddress'")
                    ->whereRaw("cpm_nopb = $noPB")
                    ->whereRaw("cpm_tglpb::date = '$tglPB'::date")
                    ->get();

                
                $insert_tocsv_pb_majalah = $this->DB_PGSQL
                    ->table('csv_pb_majalah')
                    ->insert($data_insert_majalah2);

                if (count($dtTempPBIDM2) === 0) {
                    return response()->json(['errors'=>true,'messages'=>"TIDAK ADA DATA YANG BISA JADI PB DI IGR!! (KARENA DATANYA KOSONG !!)"],422);
                    // Exit; // Uncomment if you want to exit the script here
                }
            }


            $this->DB_PGSQL->commit();
            return response()->json(['errors'=>false,'messages'=>'Data CSV Berhasil Ditarik'],200);
        } catch (\Throwable $th) {
            
            $this->DB_PGSQL->rollBack();
            // dd($th);
            return response()->json(['errors'=>true,'messages'=>$th->getMessage()],500);
        }
        return view('upload-pb-idm.page.index');
    }

    public function upload_pb_majalah_idm(Request $request){
        try {
            $this->DB_PGSQL->beginTransaction();
            $current_time = date("His");

            if ($current_time <= "235000") {
                return response()->json(['errors'=>true,'messages'=>"Mohon Tunggu Sampai JAM 12 MALAM,Untuk Melakukan UPLOAD PB/SEND JALUR!!"],422);
            }

            if ($dgvHeader->rowCount() > 0 && $dgvDetail->rowCount() > 0) {
                $noPB = $dgvHeader->currentRow()->cells[0]->value;
                $tglPB = $dgvHeader->currentRow()->cells[1]->value;
            
                
                $Lokasi2Dobel = "";
            
                
                $dtTokoTidakTerdaftar = DB::select("
                    SELECT DISTINCT CPM_KodeToko
                    FROM CSV_PB_Majalah
                    WHERE CPM_NoPB = ? AND CPM_TglPB = TO_DATE(?, 'DD-MM-YYYY') AND CPM_IP = ?
                        AND NOT EXISTS (
                            SELECT ZMI_KodeToko
                            FROM ZONA_MAJALAH_IDM
                            WHERE zmi_kodetoko = cpm_kodetoko
                        )
                ", [$noPB, $tglPB, $IP]);
            
                if (count($dtTokoTidakTerdaftar) > 0) {
                    $listToko = implode(",", array_column($dtTokoTidakTerdaftar, 'CPM_KodeToko'));
                    echo "TOKO $listToko BELUM TERDAFTAR DI ZONA_MAJALAH_IDM!!" . PHP_EOL;
                    exit;
                }
            
                
                $dtTokoTidakTerdaftar2 = DB::select("
                    SELECT DISTINCT CPM_KodeToko
                    FROM CSV_PB_Majalah
                    WHERE CPM_NoPB = ? AND CPM_TglPB = TO_DATE(?, 'DD-MM-YYYY') AND CPM_IP = ?
                        AND NOT EXISTS (
                            SELECT Tko_KodeSBU
                            FROM tbMaster_TokoIGR
                            WHERE Tko_KodeOMI = CPM_KodeToko
                        )
                ", [$noPB, $tglPB, $IP]);
            
                if (count($dtTokoTidakTerdaftar2) > 0) {
                    $listToko = implode(",", array_column($dtTokoTidakTerdaftar2, 'CPM_KodeToko'));
                    echo "TOKO $listToko Tidak Terdaftar Di TbMaster_TokoIGR !!" . PHP_EOL;
                    exit;
                }
            
                
                $dtSBUNotI = DB::select("
                    SELECT DISTINCT CPM_KodeToko
                    FROM CSV_PB_Majalah
                    WHERE CPM_NoPB = ? AND CPM_TglPB = TO_DATE(?, 'DD-MM-YYYY') AND CPM_IP = ?
                        AND EXISTS (
                            SELECT Tko_KodeSBU
                            FROM tbMaster_TokoIGR
                            WHERE Tko_KodeOMI = CPM_KodeToko AND Tko_KodeSBU <> 'I'
                        )
                ", [$noPB, $tglPB, $IP]);
            
                if (count($dtSBUNotI) > 0) {
                    $listToko = implode(",", array_column($dtSBUNotI, 'CPM_KodeToko'));
                    echo "TOKO $listToko KODE SBU nya Bukan I !!" . PHP_EOL;
                    exit;
                }
            
                
                ProsesPBIDM($txtPathFilePBM . "\\" . $dgvHeader->currentRow()->cells[5]->value);
            
                
                if ($AdaProses) {
                    
                    DB::update("
                        UPDATE CSV_PB_MAJALAH
                        SET CPM_Flag = '1'
                        WHERE CPM_IP = ? AND CPM_NoPB = ? AND CPM_TglPB = TO_DATE(?, 'DD-MM-YYYY') AND CPM_Flag IS NULL
                    ", [$getIP(), $noPB, $tglPB]);
            
                    
                    RefreshGridHeader();
            
                    
                    echo "PROSES UPLOAD PB MAJALAH No: $noPB - PSP SELESAI DILAKUKAN !" . PHP_EOL;
                }
            
                
                $dtDetailPB = new DataTable("DETAIL PB IDM");
                $dgvDetail->dataSource = $dtDetailPB;
                $dgvDetail->autoSizeColumnsMode = DataGridViewAutoSizeColumnsMode::AllCells;
                $dgvHeader->focus();
            }
            
            $this->DB_PGSQL->commit();
        } catch (\Throwable $th) {
            
            $this->DB_PGSQL->rollBack();
            dd($th);
            return response()->json(['errors'=>true,'messages'=>$th->getMessage()],500);
        }
    }
}
