<?php

namespace App\Http\Controllers;


use App\Models\Trend;
use App\Models\TikTok;
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

        return view('frontpage.trend', [
            'categories'    => $cate,
            'countInAll'    => count($titkok),
        ]);
    }

    public function recent(Request $request) {
        $params = $request->all();

        $tbl = new Trend();
        $ret = $tbl->getAllForDatatable($params);

        return response()->json($ret);
    }
}
