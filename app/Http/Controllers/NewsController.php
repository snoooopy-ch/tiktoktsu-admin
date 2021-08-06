<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\NewsCategory;
use App\Models\News;

class NewsController extends Controller
{
    public function index() {
        $categories = NewsCategory::all();
        $cate = array();
        foreach ($categories as $index => $category)
            $cate[$category['id']][] = $category->category;

        return view('news.list', [
            'categories' => $cate,
        ]);
    }

    public function category() {
        return view('news.category');
    }

    public function newslist(Request $request) {
        $params = $request->all();

        $tbl = new News();
        $ret = $tbl->getAllForDatatable($params);

        return response()->json($ret);
    }

    public function deletetiktok(Request $request, $id) {
        $news = News::where('id', $id);
        $result = $news->delete();
        return response()->json($result);
    }

    public function post() {
        $categories = NewsCategory::all();
        foreach ($categories as $index => $category)
            $cate[$category['id']][] = $category->category;

        return view('news.post',  [
            'categories' => $cate,
        ]);
    }

    public function save(Request $request) {
        $postArray      =   array( 
            "title"         => $request->title,
            "content"       => $request->content,
            "writer"        => Auth::user()->user_login,
            "category"      => $request->category,
        );

        $newsModel = new News();
        $post = $newsModel->insertNews($postArray);

        if(!is_null($post)) {
            return back()->with("success", "記事投稿に成功されました。");
        }

        else {
            return back()->with("failed", "記事投稿に失敗しました。");
        }
    }

    public function upload(Request $request) {
        if($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
        
            $request->file('upload')->move(public_path('images'), $fileName);
   
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/'.$fileName); 
            $msg = 'Image uploaded successfully'; 
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
               
            @header('Content-type: text/html; charset=utf-8'); 
            echo $response;
        }
    }

    public function addCagegory(Request $request) {
        $params = $request->all();
        $categoryName = $params['add-category'];

        $this->validate($request, [
            'add-category'  => 'required'
        ]);

        $newsCategory = new NewsCategory();
        $newsCategory->category = $params['add-category'];
        $newsCategory->save();

        return redirect()->back()->with('flash_message', 'カテゴリーが追加されました');
    }

    public function getcategories(Request $request) {
        $params = $request->all();

        $tbl = new NewsCategory();
        $ret = $tbl->getAllForDatatable($params);

        return response()->json($ret);
    }

    public function deleteCategory(Request $request, $id) {
        $newsCategory = NewsCategory::where('id', $id);
        $result = $newsCategory->delete();
        return response()->json($result);
    }

    public function modifyCategory(Request $request, $id) {
        $category = $request->only('category');
        $newsCategory = NewsCategory::where('id', $id)->first();
        $newsCategory->category = $category['category'];
        $newsCategory->save();
        return response()->json([
            'success'   => 'success'
        ], 200);
    }
}
