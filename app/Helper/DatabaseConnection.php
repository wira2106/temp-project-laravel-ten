<?php

namespace App\Helper;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Config;


class DatabaseConnection
{
    public static function setConnection($branch, $status)
    {
        try {

            if ($status == "PRODUCTION") {
                $status = "SIMULASI";
            }

            if ($branch === "22") {
                $ip = "ec2-13-213-210-138.ap-southeast-1.compute.amazonaws.com";
                $port = "5432";
                $serviceName = "igrsmg";
                $username = "postgres";
                $password = "postgres@SD1";
                $driver ="pgsql";
                $schema ="public";
            } else if($branch === "00"){
                $ip = "172.20.22.107";
                $port = "1521";
                $serviceName = "devdb";
                $username = "igrmktho";
                $password = "igrmktho";
                $driver ="oracle";
                $schema ="IGRMKTHO";
            }else{
                return "Error! Please select server from login menu.";
            }
            $ConnName = "database.connections.branchConn";
            Config::set([$ConnName => [
                'driver' => env("DB_DRIVER", $driver),
                'host' =>  env("DB_HOST", $ip),
                'port' => env("DB_PORT", $port),
                'database' => env('DB_DATABASE', $serviceName),
                'username' => env('DB_USERNAME', $username),
                'password' => env('DB_PASSWORD', $password),
                'prefix' => env("DB_PREFIX", ''),
                'schema' => $schema,
                'sslmode' => 'disable',
            ]]);

            Config::set('database.default', 'branchConn');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function AesDecrypt($cipertext)
    {
        $secret_key = '8794o08rg04hug404077ge4au3bax795';
        $secret_iv = "98428wgurhvshh35";

        $plaintext = openssl_decrypt($cipertext, "AES-256-CBC", $secret_key, OPENSSL_ZERO_PADDING, $secret_iv);
        return $plaintext;
    }
}
