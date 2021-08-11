<?php

namespace App\Http\Controllers;


use App\Models\Trend;
use App\Models\TikTok;
use App\Models\Setting;
use App\Models\TikTokCategory;
use Illuminate\Http\Request;

class TrendController extends Controller
{
    public function index() {
        $cate = array();
        $categories = TikTokCategory::all();
        foreach ($categories as $index => $category)
            $cate[$category['id']][] = $category->name;

        $titkok = TikTok::where('status', 1)->get();

        $recentCount = Setting::where('name', 'recent_count')->first();
        $laster = TikTok::orderBy('created_at', 'desc')
            ->where('status', 1)
            ->latest()->take($recentCount->value)->get();

        $start = date('Y-m-d', strtotime('now -1 days')) . ' 00:00:00';
        $end = date('Y-m-d', strtotime('now')) . ' 23:59:59';
        $surgers = TikTok::getSurge($start, $end);

        return view('frontpage.trend', [
            'categories'    => $cate,
            'countInAll'    => count($titkok),
            'laster'        => $laster,
            'start'         => date('m/d', strtotime($start)),
            'end'           => date('m/d', strtotime($end)),
            'surgers'       => $surgers,
        ]);
    }

    public function recent(Request $request) {
        $params = $request->all();

        $tbl = new Trend();
        $ret = $tbl->getAllForDatatable($params);

        return response()->json($ret);
    }
}
