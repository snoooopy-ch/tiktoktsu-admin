<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\TikTok;
use App\Models\TikTokCategory;
use App\Models\Setting;
use App\Models\News;
use App\Models\NewsCategory;
use Litipk\BigNumbers\Decimal;
use Hash;

class DashboardController extends Controller
{
    protected $keyTitles = [
        'follower'  => 'フォロワー数',
        'heart' => 'いいね数',
        'music' => '動画投稿数'
    ];
    protected $periodTitles = [
        'week'  => '週間',
        'month'  => '月間',
    ];

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
        $laster = TikTok::where('status', 1)
            ->orderBy('created_at', 'desc')
            ->latest()
            ->take($recentCount->value)
            ->get();

        $start = date('Y-m-d', strtotime('now -1 days')) . ' 00:00:00';
        $end = date('Y-m-d', strtotime('now')) . ' 23:59:59';
        $surgers = TikTok::getSurge($start, $end);

        $query = News::query();
        $news = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        $newsCategory = array();
        $categories = NewsCategory::all();
        foreach ($categories as $index => $category)
            $newsCategory[$category['id']] = $category->category;

        foreach($news  as $index => $item) {
            preg_match('/(<)([img])(\w+)([^>]*>)/', $item->content, $match);
            if (count($match) != 0) {
                $image = $match[0];
                $array = array();
                preg_match('/<img[^>]* src=\"([^\"]*)\"[^>]*>/', $image, $array );
                $item->thumb = $array[1];
            }
            else {
                $item->thumb = '';
            } 

            $item->content = preg_replace('/(<)([img])(\w+)([^>]*>)/', '', $item->content); 
            preg_match('/^(.*)$/m', $item->content, $match);
            $item->content = $match[0];

            preg_match('/^(.*)$/m', $item->title, $match);
            $item->title = $match[0];

            $item->category = $newsCategory[$item->category] ?? '';
        }

        $newsModel = new News();
        $topNews = $newsModel->famouseNews();

        return view('frontpage.dashboard', [
            'search-ids'    => $ids,
            'categories'    => $cate,
            'countInAll'    => count($titkok),
            'laster'        => $laster,
            'start'         => date('m/d', strtotime($start)),
            'end'           => date('m/d', strtotime($end)),
            'surgers'       => $surgers,
            'news'          => $news,
            'topNews'       => $topNews,
        ]);
    }

    public function ranking(Request $request) {
        $key = $request->route('key');
        $period = $request->route('period');

        $pageTitle = 'ランキング';
        if ($key !== null && $key !== '') {
            $pageTitle = $this->keyTitles[$key] . $pageTitle;
        }
        if ($period !== null && $period !== '') {
            $pageTitle = $this->periodTitles[$period] . $pageTitle;
        }

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
        $laster = TikTok::where('status', 1)
            ->orderBy('created_at', 'desc')
            ->latest()
            ->take($recentCount->value)
            ->get();

        $start = date('Y-m-d', strtotime('now -1 days')) . ' 00:00:00';
        $end = date('Y-m-d', strtotime('now')) . ' 23:59:59';
        $surgers = TikTok::getSurge($start, $end);

        // $categories = NewsCategory::all();
        // $cate = array();
        // foreach ($categories as $index => $category)
        //     $cate[$category['id']][] = $category->category;

        return view('frontpage.ranking', [
            'search-ids'    => $ids,
            'categories'    => $cate,
            'countInAll'    => count($titkok),
            'laster'        => $laster,
            'start'         => date('m/d', strtotime($start)),
            'end'           => date('m/d', strtotime($end)),
            'surgers'       => $surgers,
            'pageTitle'     => $pageTitle,
        ]);
    }

    public function category(Request $request) {
        $categoryIndex = $request->route('category');
        $categoryName = TikTokCategory::where('id', $categoryIndex)->first();

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
        $laster = TikTok::where('status', 1)
            ->orderBy('created_at', 'desc')
            ->latest()
            ->take($recentCount->value)
            ->get();

        $start = date('Y-m-d', strtotime('now -1 days')) . ' 00:00:00';
        $end = date('Y-m-d', strtotime('now')) . ' 23:59:59';
        $surgers = TikTok::getSurge($start, $end);

        // $categories = NewsCategory::all();
        // $cate = array();
        // foreach ($categories as $index => $category)
        //     $cate[$category['id']][] = $category->category;

        return view('frontpage.category', [
            'search-ids'    => $ids,
            'categories'    => $cate,
            'countInAll'    => count($titkok),
            'laster'        => $laster,
            'start'         => date('m/d', strtotime($start)),
            'end'           => date('m/d', strtotime($end)),
            'surgers'       => $surgers,
            'categoryName'  => $categoryName,
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
