<?php

namespace App\Http\Controllers;

use App\Helper\DatabaseConnection;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Queue\Connectors\DatabaseConnector;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    function index()
    {
        return view("layouts.home");
    }

    /**
     * Save Data User
     *
     * @param   Request  $req  [$req description]
     *
     * @return  [type]         [return description]
     */

    public function insertUser(Request $req)
    {
        DB::beginTransaction();
        try {
            $arr = [];
            $insert = DB::table("tbmaster_user")->insert($arr);

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Data has been successfully saved.'
            ], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to saved data, please try again',
                'errorMessage' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * [getUser description]
     *
     * @param   Request  $req  [$req description]
     *
     * @return  [type]         [return description]
     */

    public function getUser(Request $req)
    {
        try {
            $data = DB::table("tbmaster_customer")
                ->where("userid", "DV1")
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to get data, please try again',
                'errorMessage' => $e->getMessage()
            ], 400);
        }
    }
}
