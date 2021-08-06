<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\TikTok;
use App\Models\TikTokCategory;
use Hash;

class DashboardController extends Controller
{
    public function index() {
        $tiktok = TikTok::all();
        
        $ids = array();
        foreach($tiktok as $index => $value) {
            $ids[] = $value->uniqueId;
        }

        $cate = array();
        $categories = TikTokCategory::all();
        foreach ($categories as $index => $category)
            $cate[$category['id']][] = $category->name;

        $titkok = TikTok::where('status', 1)->get();
        return view('frontpage.home', [
            'search-ids'    => $ids,
            'categories'    => $cate,
            'countInAll'    => count($titkok),
        ]);
    }

    public function getUsersInFrontPage(Request $request) {
        $params = $request->all();
        $params['status'] = TIKTOK_STATUS_CONFIRM;

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
