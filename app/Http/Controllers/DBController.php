<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Customer;
use Hash;
use DB;

class DBController extends Controller
{
    function index() {
        return view('db');
    }

    function download() {
        $date = date('Ymdhis', time()) . '.sql';
        $sqlfile = public_path('database_download/' . $date);
          
        $db = [
            'username'  => env('DB_USERNAME'),
            'password'  => env('DB_PASSWORD'),
            'host'      => env('DB_HOST'),
            'database'  => env('DB_DATABASE'),
            'port'      => env('DB_PORT')
        ];
  
        $sql = "mysqldump --user={$db['username']} --password={$db['password']} --host={$db['host']} --port={$db['port']} --database {$db['database']} --ignore-table=sales_db.tbl_admin > $sqlfile";
        exec($sql);

        // return $sql;
        return response()->download($sqlfile);
    }

    function upload() {
        $date = date('Ymdhis', time()) . '.sql';
        $sqlfile = public_path('database_upload/' . $date);

        $file = request()->file('uploadFile');
        $ret = $file->move(public_path() . '/database_upload', $file->getClientOriginalName());

        $db = [
            'username'  => env('DB_USERNAME'),
            'password'  => env('DB_PASSWORD'),
            'host'      => env('DB_HOST'),
            'database'  => env('DB_DATABASE'),
            'port'      => env('DB_PORT')
        ];
  
        $sql = "mysql --user={$db['username']} --password={$db['password']} --host={$db['host']} --port={$db['port']} --database {$db['database']} < $ret";
        exec($sql);

        return 1;
    }
}
