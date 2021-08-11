<?php

namespace App\Http\Controllers;

use App\Models\TikTokCategory;
use App\Models\TikTok;
use App\Models\Setting;
use Illuminate\Http\Request;

class PublishController extends Controller
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

        return view('frontpage.publish', [
            'categories'    => $cate,
            'countInAll'    => count($titkok),
            'laster'        => $laster,
            'start'         => date('m/d', strtotime($start)),
            'end'           => date('m/d', strtotime($end)),
            'surgers'       => $surgers,
        ]);
    }

    public function send(Request $request) {
        $this->validate($request, [
            'uniqueId' => 'required|unique:tbl_user'
        ]);

        $params = $request->only('uniqueId');
        $tiktok = new TikTok();
        $tiktok->uniqueId = $params['uniqueId'];
        $tiktok->save();

        return redirect()->back()->with('flash_message', '登録されました。掲載まで数日かかることがあります。');
    }
}
