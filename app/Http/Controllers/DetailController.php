<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\TikTok;
use App\Models\TikTokCategory;
use App\Models\Setting;
use Litipk\BigNumbers\Decimal;
use Hash;

class DetailController extends Controller
{
    public function index(Request $request, $id) {
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

        if ($tiktokInfo->heart == 0) {
            $rate = Decimal::create(0);
        } else {
            $rate = Decimal::create($tiktokInfo->follercount)->div(Decimal::create($tiktokInfo->heart))->mul(Decimal::create(100));
        }
        

        $recentCount = Setting::where('name', 'recent_count')->first();
        $laster = TikTok::orderBy('created_at', 'desc')
            ->where('status', 1)
            ->latest()->take($recentCount->value)->get();

        $start = date('Y-m-d', strtotime('now -1 days')) . ' 00:00:00';
        $end = date('Y-m-d', strtotime('now')) . ' 23:59:59';
        $surgers = TikTok::getSurge($start, $end);


        return view('frontpage.user.index', [
            'tiktokInfo'    => $tiktokInfo,
            'follerRank'    => $follerRank,
            'heartRank'     => $heartRank,
            'categories'    => $cate,
            'countInAll'    => count($titkok),
            'trends'        => $trends,
            'rate'          => $rate->__toString(),
            'laster'        => $laster,
            'start'         => date('m/d', strtotime($start)),
            'end'           => date('m/d', strtotime($end)),
            'surgers'       => $surgers,
        ]);
    }

    public function getUserDetailHistory(Request $request) {
        $params = $request->all();

        $first = date('Y-m-d', strtotime('now -1 month'));
        $end = date('Y-m-d', strtotime('now'));
        $params['period'] = [$first, $end];

        $params['id'] = $request->route('id');

        $tbl = new TikTok();
        $ret = $tbl->getHistoryForDatatable($params);

        return response()->json($ret);
    }
}
