<?php

namespace App\Http\Controllers;

use App\Models\TikTokCategory;
use App\Models\TikTok;
use Illuminate\Http\Request;

class PublishController extends Controller
{
    public function index() {
        $cate = array();
        $categories = TikTokCategory::all();
        foreach ($categories as $index => $category)
            $cate[$category['id']][] = $category->name;
        
        $titkok = TikTok::where('status', 1)->get();

        return view('frontpage.publish', [
            'categories'    => $cate,
            'countInAll'    => count($titkok),
        ]);
    }

    public function send(Request $request) {
        $this->validate($request, [
            'tiktok-uniqueId' => 'required'
        ]);

        $params = $request->only('tiktok-uniqueId');
        $tiktok = new TikTok();
        $tiktok->uniqueId = $params['tiktok-uniqueId'];
        $tiktok->save();

        return redirect()->back()->with('flash_message', '登録されました。掲載まで数日かかることがあります。');
    }
}
