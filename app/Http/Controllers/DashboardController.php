<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\TikTok;
use App\Models\TikTokCategory;
use App\Models\Setting;
use Litipk\BigNumbers\Decimal;
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

        $recentCount = Setting::where('name', 'recent_count')->first();

        $titkok = TikTok::where('status', 1)->get();
        $laster = TikTok::orderBy('created_at', 'desc')->latest()->take($recentCount->value)->get();

        $start = date('Y-m-d', strtotime('now -1 days')) . ' 00:00:00';
        $end = date('Y-m-d', strtotime('now')) . ' 23:59:59';
        $surgers = TikTok::getSurge($start, $end);

        return view('frontpage.dashboard', [
            'search-ids'    => $ids,
            'categories'    => $cate,
            'countInAll'    => count($titkok),
            'laster'        => $laster,
            'start'         => date('m/d', strtotime($start)),
            'end'           => date('m/d', strtotime($end)),
            'surgers'       => $surgers,
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

        $rate = Decimal::create($tiktokInfo->follercount)->div(Decimal::create($tiktokInfo->heart))->mul(Decimal::create(100));

        return view('frontpage.user.index', [
            'tiktokInfo'    => $tiktokInfo,
            'follerRank'    => $follerRank,
            'heartRank'     => $heartRank,
            'categories'    => $cate,
            'countInAll'    => count($titkok),
            'trends'        => $trends,
            'rate'          => $rate->__toString(),
        ]);
    }
}
