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

    
}
