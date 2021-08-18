<?php

namespace App\Http\Controllers;

use App\Models\TikTokCategory;
use App\Models\TikTok;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function about() {
        $cate = array();
        $categories = TikTokCategory::all();
        foreach ($categories as $index => $category)
            $cate[$category['id']][] = $category->name;

        $titkok = TikTok::where('status', 1)->get();

        return view('frontpage.footerpage.about', [
            'categories'    => $cate,
            'countInAll'    => count($titkok),
        ]);
    }

    public function media() {
        $cate = array();
        $categories = TikTokCategory::all();
        foreach ($categories as $index => $category)
            $cate[$category['id']][] = $category->name;

        $titkok = TikTok::where('status', 1)->get();

        return view('frontpage.footerpage.media', [
            'categories'    => $cate,
            'countInAll'    => count($titkok),
        ]);
    }

    public function term() {
        $cate = array();
        $categories = TikTokCategory::all();
        foreach ($categories as $index => $category)
            $cate[$category['id']][] = $category->name;

        $titkok = TikTok::where('status', 1)->get();

        return view('frontpage.footerpage.term', [
            'categories'    => $cate,
            'countInAll'    => count($titkok),
        ]);
    }

    public function privacy() {
        $cate = array();
        $categories = TikTokCategory::all();
        foreach ($categories as $index => $category)
            $cate[$category['id']][] = $category->name;

        $titkok = TikTok::where('status', 1)->get();

        return view('frontpage.footerpage.privacy', [
            'categories'    => $cate,
            'countInAll'    => count($titkok),
        ]);
    }

    public function company() {
        $cate = array();
        $categories = TikTokCategory::all();
        foreach ($categories as $index => $category)
            $cate[$category['id']][] = $category->name;

        $titkok = TikTok::where('status', 1)->get();

        return view('frontpage.footerpage.company', [
            'categories'    => $cate,
            'countInAll'    => count($titkok),
        ]);
    }
}
