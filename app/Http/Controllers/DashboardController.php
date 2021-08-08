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
        return view('frontpage.dashboard', [
            'search-ids'    => $ids,
            'categories'    => $cate,
            'countInAll'    => count($titkok),
        ]);
    }

    public function view1() {
        
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

    public function getUserInfo(Request $request, $id) {
        $userID = $id;

        $cate = array();
        $categories = TikTokCategory::all();
        foreach ($categories as $index => $category)
            $cate[$category['id']][] = $category->name;

        $tiktokInfo = TikTok::where('id', $id)->first();
        if ($tiktokInfo == null) {
            return redirect()->back();
        }
        $tiktokInfo->category = array_key_exists($tiktokInfo->category, $cate)? $cate[$tiktokInfo->category][0] : '';

        $collection = collect(TikTok::orderBy('follercount', 'desc')->get());
        $data = $collection->where('id', $id);
        $follerRank = $data->keys()->first() + 1;

        $collection = collect(TikTok::orderBy('heart', 'desc')->get());
        $data = $collection->where('id', $id);
        $heartRank = $data->keys()->first() + 1;

        $titkok = TikTok::where('status', 1)->get();

        $trends = Tiktok::trends($id);

        return view('frontpage.user.index', [
            'tiktokInfo'    => $tiktokInfo,
            'follerRank'    => $follerRank,
            'heartRank'     => $heartRank,
            'categories'    => $cate,
            'countInAll'    => count($titkok),
            'trends'        => $trends,
        ]);
    }
}
