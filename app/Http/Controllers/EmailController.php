<?php

namespace App\Http\Controllers;

use App\Traits\LibraryCSV;
use Illuminate\Http\Request;
use DB;

class EmailController extends Controller
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
        return view('email.index');
    }
    
    public function check_email(Request $request){
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
        if($data_email){
            $message = "Berhasil";
            $error = false;
            $code = 200;
        }else{
            $message = "Data Tidak Ada";
            $error = true;
            $code = 404;
        }

        return response()->json(['errors'=>$error,'messages'=>$message,'data_email' => $data_email],$code);
    }

    public function store(Request $request){
        try {
            $this->DB_PGSQL->beginTransaction();
                    $data_email = $this->DB_PGSQL
                           ->table("master_email_cabang")
                           ->insert([
                                "mec_mail_server" => $request->servers,
                                "mec_mail_port" => $request->port,
                                "mec_mail_user" => $request->email,
                                "mec_mail_pass" => $request->password,
                                "mec_to" => $request->to,
                                "mec_cc" => $request->cc,
                                "mec_subject" => $request->subject,
                           ]);

            
            $this->DB_PGSQL->commit();
            return response()->json(['errors'=>false,'messages'=>"berhasil"],200);
        } catch (\Throwable $th) {
            
            $this->DB_PGSQL->rollBack();
            // dd($th);
            return response()->json(['errors'=>true,'messages'=>$th->getMessage()],500);
        }
    }
    public function update(Request $request){
        try {
            $this->DB_PGSQL->beginTransaction();
                    $data_email = $this->DB_PGSQL
                           ->table("master_email_cabang")
                           ->update([
                                "mec_mail_server" => $request->servers,
                                "mec_mail_port" => $request->port,
                                "mec_mail_user" => $request->email,
                                "mec_mail_pass" => $request->password,
                                "mec_to" => $request->to,
                                "mec_cc" => $request->cc,
                                "mec_subject" => $request->subject,
                           ]);
    
            
            $this->DB_PGSQL->commit();
            return response()->json(['errors'=>false,'messages'=>"berhasil"],200);
        } catch (\Throwable $th) {
            
            $this->DB_PGSQL->rollBack();
            // dd($th);
            return response()->json(['errors'=>true,'messages'=>$th->getMessage()],500);
        }

    }
    
}
