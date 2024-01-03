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
        // $this->DB_ORACLE = DB::connection('oracle');
        $this->no_db = true;

        // try {
        //     $this->DB_ORACLE->beginTransaction();

            
        //     $this->DB_ORACLE->commit();
        // } catch (\Throwable $th) {
            
        //     $this->DB_ORACLE->rollBack();
        //     dd($th);
        //     return response()->json(['errors'=>true,'messages'=>$th->getMessage()],500);
        // }
    }

    public function get_list_alasan(Request $request){
        if ($this->no_db) {

        $faker = Faker::create('id_ID');
            $result = [];
            $page_start = 1;
            $page_end = $request->page*10;
    
            if($request->page > 1){
                $page_start = $page_end - 9;
            }

            for ($i = $page_start; $i <= $page_end; $i++) {
                $alasan = $faker->randomElement([
                    'MASALAH JARINGAN',
                    'TOKO BARU',
                    'ERROR PROGRAM KOMPUTER DI PC',
                    'ERROR PERHITUNGAN DI PC',
                ]);
                
                $result[] = (object)[
                    "ALASAN" => $alasan." ".$i,
                    "CREATE_DT"=>date('Y-m-d H:i:s'),
                    "MODIFY_DT"=>date('Y-m-d H:i:s'),
                ];
    
            }
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
        if ($this->no_db) {
            return response()->json(['errors'=>false,'messages'=>'berhasil'],200);
        } else {
            $this->DB_ORACLE->beginTransaction();
            try {
                $this->validate($request, [
                    'alasan_baru' => 'required',
                ]);
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
        if ($this->no_db) {
            return response()->json(['errors'=>false,'messages'=>'berhasil'],200);
        } else {
            $this->DB_ORACLE->beginTransaction();
            try {
    
                $this->validate($request, [
                    'alasan_baru' => 'required',
                ]);
    
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
                        ->table("MASTER_ALASAN_PBDARURAT")
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
}
