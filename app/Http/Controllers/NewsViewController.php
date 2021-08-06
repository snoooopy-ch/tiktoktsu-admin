<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\TikTok;
use App\Models\TikTokCategory;
use App\Models\NewsCategory;
use Illuminate\Http\Request;

class NewsViewController extends Controller
{
    public function index() {
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

        $cate = array();
        $categories = TikTokCategory::all();
        foreach ($categories as $index => $category)
            $cate[$category['id']][] = $category->name;

        $titkok = TikTok::where('status', 1)->get();
        return view('frontpage.news.news', [
            'news'              => $news,
            'topNews'           => $topNews,
            'categories'        => $cate,
            'countInAll'    => count($titkok),
        ]);
    }

    public function view(Request $request) {
        $id = $request->route('id');
        $newsModel = new News();
        $topNews = $newsModel->famouseNews();
        $newsData = $newsModel->increaseReadAndGet($id);

        $cate = array();
        $categories = TikTokCategory::all();
        foreach ($categories as $index => $category)
            $cate[$category['id']][] = $category->name;

        $titkok = TikTok::where('status', 1)->get();
        return view('frontpage.news.newsview', [
            'news'              => $newsData,
            'topNews'           => $topNews,
            'categories'        => $cate,
            'countInAll'        => count($titkok),
        ]);
    }
}
