<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    public function index() {
        return view('news');
    }

    public function newslist(Request $request) {
        $params = $request->all();

        $tbl = new News();
        $ret = $tbl->getAllForDatatable($params);

        return response()->json($ret);
    }

    public function post() {
        return view('post');
    }

    public function save(Request $request) {
        $postArray      =   array( 
            "title"         => $request->title,
            "content"       => $request->content,
            "writer"        => 'admin',
        );

        $newsModel = new News();
        $post = $newsModel->insertNews($postArray);

        if(!is_null($post)) {
            return back()->with("success", "Success! Post created");
        }

        else {
            return back()->with("failed", "Failed! Post not created");
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
}
