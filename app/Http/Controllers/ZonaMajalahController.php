<?php

namespace App\Http\Controllers;

use App\Transformers\DataZonaTransformers;
use Illuminate\Http\Request;
use DB;

class ZonaMajalahController extends Controller
{
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

        return view('zona-majalah.page.index');
    }

    public function get_data_zona(Request $request){
    
        $result = $this->DB_PGSQL
                       ->table("zona_majalah_idm")
                       ->selectRaw("ZMI_ZONA as ZONA, ZMI_KodeTOKO as toko");
        if($request->cari){
        $cari = $request->searcj;
        $result = $result
                        ->where(function ($query) use ($cari) {
                            $query->where('zona_majalah_idm.zmi_zona', 'LIKE', '%' . $cari . '%')
                                ->orWhere('zona_majalah_idm.zmi_kodetoko', 'LIKE', '%' . $cari . '%');
                        });
        }
        $result = $result
                       ->orderBy("zmi_zona","asc")
                       ->orderBy("zmi_kodetoko","asc")
                       ->get();
    
        if (!empty($result)) {
            return DataZonaTransformers::collection($result);
        }else {
            return $result;
        }

    }

    public function get_data_toko(Request $request){
        $query_exists = $this->DB_PGSQL
                            ->table("zona_majalah_idm")
                            ->selectRaw("ZMI_KodeToko")
                            ->whereRaw("zmi_kodetoko = tko_kodeomi")
                            ->toSql();
        $result = $this->DB_PGSQL
                            ->table("tbmaster_tokoigr")
                            ->selectRaw("tko_kodeomi")
                            ->whereRaw("tko_kodesbu = 'I' ")
                            ->whereRaw("NOT EXISTS($query_exists)")
                            ->orderBy("tko_kodeomi","asc")
                            ->get();
        return $result;
        
    }

    public function save(Request $request){
        try {
            $this->DB_PGSQL->beginTransaction();
            $this->validate($request, [
                'toko' => 'required',
                'zona' => 'required',
            ]);
            $jum = $this->DB_PGSQL->table('zona_majalah_idm')
                        ->where('zmi_zona', $request->zona)
                        ->where('zmi_kodetoko', $request->toko)
                        ->count();
                if (!$jum) {
                    $this->DB_PGSQL->table('zona_majalah_idm')->insert([
                        'zmi_zona' => $request->zona,
                        'zmi_kodetoko' => $request->toko,
                        'zmi_create_by' => session('userid'),
                        'zmi_create_dt' => date('Y-m-d H:i:s'),
                    ]);

                    $message = "Data Zona Majalah Berhasil Ditambahkan";
                } else {
                    $this->DB_PGSQL->table('zona_majalah_idm')
                        ->where('zmi_zona', $request->zona)
                        ->where('zmi_kodetoko', $request->toko)
                        ->update([
                            // 'zmi_modify_by' => session('userid'),
                            // 'zmi_modify_dt' => date('Y-m-d H:i:s'),
                            'zmi_create_by' => session('userid'),
                            'zmi_create_dt' => date('Y-m-d H:i:s'),
                        ]);

                    $message = "Data Zona Majalah Berhasil Di Update";
                }
            $this->DB_PGSQL->commit();

            return response()->json(['errors'=>false,'messages'=>$message],200);
        } catch (\Throwable $th) {
            
            $this->DB_PGSQL->rollBack();
            // dd($th);
            return response()->json(['errors'=>true,'messages'=>$th->getMessage()],500);
        }
    }
}
