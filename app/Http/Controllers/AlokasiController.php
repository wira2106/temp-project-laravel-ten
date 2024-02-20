<?php

namespace App\Http\Controllers;

use App\Traits\LibraryCSV;
use Illuminate\Http\Request;
use DB;

class AlokasiController extends Controller
{
    use LibraryCSV;
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
        return view('alokasi.seasonal.index');
    }
    public function inde_khusus(){
        return view('alokasi.khusus.index');
    }
}
