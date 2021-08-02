<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\TikTok;
use Hash;

class DashboardController extends Controller
{
    public function index() {
        $tiktok = TikTok::all();
        $ids = array();

        foreach($tiktok as $index => $value) {
            $ids[] = $value->uniqueId;
        }
        return view('frontpage.home', [
            'search-ids' => $ids,
        ]);
    }

    public function getUsersInFrontPage(Request $request) {
        $params = $request->all();

        $tbl = new TikTok();
        $ret = $tbl->getAllForDatatable($params);

        return response()->json($ret);
    }

    public function deletetiktok(Request $request, $id) {
        $tiktokModel = new TikTok();
        $result = $tiktokModel->deleteRecord($id);
        return response()->json($result);
    }

}
