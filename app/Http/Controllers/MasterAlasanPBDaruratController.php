<?php

namespace App\Http\Controllers;

use App\Transformers\DataAlasanPBTransformers;
use Illuminate\Http\Request;
use DB;
use Faker\Factory as Faker;

class MasterAlasanPBDaruratController extends Controller
{
    public $DB_ORACLE;
    public $no_db = false;
    public function __construct() {
        // $this->no_db = true;
        if(!( $this->no_db)){
            $this->DB_ORACLE = DB::connection('oracle');
        }

        // try {
        //     $this->DB_ORACLE->beginTransaction();

            
        //     $this->DB_ORACLE->commit();
        // } catch (\Throwable $th) {
            
        //     $this->DB_ORACLE->rollBack();
        //     dd($th);
        //     return response()->json(['errors'=>true,'messages'=>$th->getMessage()],500);
        // }
    }

    public function index(){
        view('master-alasan-pb-darurat.home');
    }

    public function get_list_alasan(Request $request){
        if ($this->no_db) {
        
        $json_data = '[{"ALASAN" : "DIPERLUKAN UBAH JADWAL MENDADAK KARENA KASUS","CREATE_DT" : "2023-02-22","MODIFY_DT" : "2023-11-27"},{"ALASAN" : "TIDAK RECEIVE 90 MENIT TEST","CREATE_DT" : "2023-02-22","MODIFY_DT" : "2023-10-27"},{"ALASAN" : "MASALAH JARINGAN","CREATE_DT" : "2023-02-22","MODIFY_DT" : "2023-10-25"},{"ALASAN" : "SERVER PB RO DOWN\/BERMASALAH","CREATE_DT" : "2023-02-22","MODIFY_DT" : "2023-10-27"},{"ALASAN" : "ERROR PERHITUNGAN DIPROGRAM KOMPUTER RO","CREATE_DT" : "2023-02-22","MODIFY_DT" : "2023-10-27"},{"ALASAN" : "ERROR DIPROGRAM KOMPUTER DCI","CREATE_DT" : "2023-02-22","MODIFY_DT" : "2023-10-27"},{"ALASAN" : "TOKO BARU","CREATE_DT" : "2023-10-25","MODIFY_DT" : null},{"ALASAN" : "ALASAN FL","CREATE_DT" : "2023-11-27","MODIFY_DT" : null}]';
        $result = json_decode($json_data);
        } else {
            $result = $this->DB_ORACLE
                           ->table("MASTER_ALASAN_PBDARURAT")
                           ->orderBy("ALASAN","asc")
                           ->skip($request->page * 10)
                           ->take(10)
                           ->get();
            
        }
        

        return DataAlasanPBTransformers::collection($result);
    }

    public function add(Request $request){

        $this->validate($request, [
            'alasan_baru' => 'required',
        ]);
        if ($this->no_db) {
            return response()->json(['errors'=>false,'messages'=>'berhasil'],200);
        } else {
            $this->DB_ORACLE->beginTransaction();
            try {
                $alasan_baru = strtoupper($request->alasan_baru);
                $check_same_alasan = $this->DB_ORACLE->table("MASTER_ALASAN_PBDARURAT")->whereRaw("ALASAN = '$alasan_baru'")->first();
                if ($check_same_alasan) {
                    return response()->json(['errors'=>true,'messages'=>'Alasan Sudah Terdaftar, silahkan coba yang lain'],500);
                }
                $arr = [
                        "ALASAN" => $alasan_baru,
                        "CREATE_DT"=> date('Y-m-d H:i:s'),
                        "MODIFY_DT"=> null,
                    ];
                
                $insert = $this->DB_ORACLE->table("MASTER_ALASAN_PBDARURAT")->insert($arr);
    
                $this->DB_ORACLE->commit();
                return response()->json(['errors'=>false,'messages'=>'Alasan Berhasil Ditambah'],200);
    
            } catch (Exception $e) {
                $this->DB_ORACLE->rollback();
                return response()->json(['errors'=>true,'messages'=>$e->getMessage()],500);
            }
        }
        

    }

    public function update(Request $request){
            
        $this->validate($request, [
            'alasan_baru' => 'required',
            'alasan_dipilih' => 'required',
        ]);
        if ($this->no_db) {
            return response()->json(['errors'=>false,'messages'=>'berhasil'],200);
        } else {
            $this->DB_ORACLE->beginTransaction();
            try {
    
                $alasan_dipilih = strtoupper($request->alasan_dipilih);
                $alasan_baru = strtoupper($request->alasan_baru);
                $check_same_alasan = $this->DB_ORACLE->table("MASTER_ALASAN_PBDARURAT")->whereRaw("ALASAN = '$alasan_dipilih'")->first();
                if ($check_same_alasan) {
                    return response()->json(['errors'=>true,'messages'=>'Alasan Sudah Terdaftar, silahkan coba yang lain'],500);
                }
    
                $this->validate($request, [
                    'alasan_baru' => 'required',
                ]);
    
                $this->DB_ORACLE
                     ->table("MASTER_ALASAN_PBDARURAT")
                     ->whereRaw("ALASAN = '$alasan_dipilih'")
                     ->update([
                        "ALASAN" => $alasan_baru,
                        "MODIFY_DT"=> date('Y-m-d H:i:s'),
                     ]);
    
                $this->DB_ORACLE->commit();
    
                return response()->json(['errors'=>false,'messages'=>'berhasil'],200);
            } catch (Exception $e) {
                $this->DB_ORACLE->rollback();
                
                return response()->json(['errors'=>true,'messages'=>$e->getMessage()],500);
            }
        }
        

    }
    
    public function delete(Request $request){
        if ($this->no_db) {
            return response()->json(['errors'=>false,'messages'=>'berhasil'],200);
        } else {
            $this->DB_ORACLE->beginTransaction();
            try {
                $this->validate($request, [
                    'alasan_dipilih' => [
                        function ($attribute, $value, $fail)  {
                           
                            if ($value) {
                                $fail($attribute . ' must be selected');
                            }
                        }
                    ]
                ]);

                $this->DB_ORACLE
                        ->table("master_alasan_pbdarurat")
                        ->whereRaw("ALASAN = '$alasan_dipilih'")
                        ->delete();
                
                
    
                $this->DB_ORACLE->commit();
    
                return response()->json(['errors'=>false,'messages'=>'berhasil'],200);
            } catch (Exception $e) {
                $this->DB_ORACLE->rollback();
                return response()->json(['errors'=>true,'messages'=>$e->getMessage()],500);
            }
        }

    }

    public function kirim(Request $request){
        if ($this->no_db) {
            return response()->json(['errors'=>false,'messages'=>'berhasil'],200);
        } else {
            // Get list of reasons (assuming GetListAlasan() and GetListCabang() are implemented elsewhere)
            $tbAlasan = $this->get_data_alasan();
            $tbCabang = $this->get_list_cabang();
            $alasan = [];

            $count = 0;
                try {
                    foreach ($tbCabang as $roww) {
                        $count++;

                        // Establish Oracle connection
                        Config::set([$roww->nama_igr => [
                            'driver' => 'oracle',
                            'host' =>  $roww->server_name,
                            'port' => $roww->port,
                            'database' => $roww->service_name,
                            'username' => $roww->username,
                            'password' => $roww->password,
                            'prefix' => '',
                            'sslmode' => 'disable',
                        ]]);
                        $this->DB_ORACLE = DB::connection($roww->nama_igr);
                        $this->DB_ORACLE->beginTransaction();
                        

                        // Delete records from master_alasan_pbdarurat
                        $this->DB_ORACLE->table('master_alasan_pbdarurat')->delete();

                        foreach ($tbAlasan as $roww2) {
                            $tempDate = strtotime($roww2[1]);
                            $strsql = "insert into master_alasan_pbdarurat values ('" . $roww2[0] . "', TO_DATE('" . date('d/m/Y', $tempDate) . "', 'DD-MM-YYYY'), ";

                            if (empty($roww2[2])) {
                                $strsql .= "null)";
                            } else {
                                $tempDate = strtotime($roww2[2]);
                                $strsql .= "TO_DATE('" . date('d/m/Y', $tempDate) . "', 'DD-MM-YYYY'))";
                            }

                            $alasan [] = [
                                "ALASAN" => $alasan_baru,
                                "CREATE_DT"=> date('Y-m-d H:i:s'),
                                "MODIFY_DT"=> null,
                            ];
                        }

                        $insert = $this->DB_ORACLE->table("MASTER_ALASAN_PBDARURAT")->insert($arr);

                    
                        $this->DB_ORACLE->commit();
                        
                    }        
                    
                    // back use default connection
                    $this->DB_ORACLE = DB::connection('oracle');

                    if ($count === count($tbCabang)) {
                        
                        return response()->json(['errors'=>false,'messages'=>'Data Selesai Di Proses !!'],200); 
                    } else {
                        
                        return response()->json(['errors'=>true,'messages'=>"Data Gagal Diproses"],500);
                    }
                } catch (Exception $ex) {

                    $this->DB_ORACLE->rollback();
                    
                    return response()->json(['errors'=>true,'messages'=>$ex->getMessage()],500);
                }
        }


    }

    public function get_data_alasan(){

        // Assuming you are in a Laravel Controller or Service

        // Perform the initial query using Laravel's query builder
        $results = $this->DB_ORACLE->table('master_alasan_pbdarurat')->get();

        // Create a new Laravel Collection to mimic a DataTable
        $tbAlasantemp = collect();

        // Define the columns for the new collection
        $tbAlasantemp->push([
            'ALASAN',
            'CREATE_DT',
            'MODIFY_DT',
        ]);

        // Transform the data and populate the new collection
        foreach ($results as $row) {
            $nrow = [
                'ALASAN' => $row->alasan,
                'CREATE_DT' => $row->create_dt,
                'MODIFY_DT' => $row->modify_dt,
            ];

            $tbAlasantemp->push((object)$nrow);

        }

        // Return the resulting collection
        return $tbAlasantemp;

    }

    public function get_list_cabang(){
        // Assuming you are in a Laravel Controller or Service

        // Perform the initial query using Laravel's query builder
        $results = $this->DB_ORACLE->table('master_db_igr_idm')
                    ->select('kode_igr', 'cab_namacabang', 'jenis_db', 'server_name', 'port', 'username', 'password', 'service_name')
                    ->join('tbmaster_cabang', 'master_db_igr_idm.kode_igr', '=', 'tbmaster_cabang.cab_kodecabang')
                    ->orderBy('jenis_db')
                    ->orderBy('kode_igr')
                    ->get();

        // Transform the data and populate the new collection
        foreach ($results as $row) {
            $nrow = [
                'kode_igr' => $row->kode_igr,
                'nama_igr' => $row->jenis_db === 'SIMULASI' ? 'SIMULASI ' . $row->cab_namacabang : $row->cab_namacabang,
                'jenis_db' => $row->jenis_db,
                'server_name' => $row->server_name,
                'port' => $row->port,
                'username' => $row->username,
                'password' => $row->password,
                'service_name' => $row->service_name,
            ];
        }

        $tbCabangTemp->push((object)$nrow);


        // Return the resulting collection
        return $tbCabangTemp;

    }
}