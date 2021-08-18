<?php

namespace App\Http\Controllers;

use Session;
use App\Models\Setting;
use App\Models\TikTokCategory;
use App\Models\TikTok;
use Illuminate\Http\Request;
use App\MailManager;

class ContactController extends Controller
{
    public function index() {
        $cate = array();
        $categories = TikTokCategory::all();
        foreach ($categories as $index => $category)
            $cate[$category['id']][] = $category->name;

        $titkok = TikTok::where('status', 1)->get();

        return view('frontpage.footerpage.contact', [
            'categories'    => $cate,
            'countInAll'    => count($titkok),
        ]);
    }

    function send(Request $request) {
        $record = $request->only('email', 'title', 'content');

        $this->validate($request, [
            'content'  => ['required'],
            'title'     => ['required'],
            'email'     => ['required', 'email'],
        ], [
            'content.required'  => 'お問い合わせ内容を入力ください。',
            'title.required'  => 'お問い合わせタイトルを入力ください。',
            'email.required'  => 'メールアドレスを入力ください。',
            'email.email'  => 'メールアドレス形式で入力ください。'
        ]);

        $response = null;
        try {

            $support_mail = Setting::where('name', 'mail_to')->first();
            $ret = MailManager::send_contactmail($record['title'], $record['content'], $record['email'], $support_mail->value);
            if ($ret == false) {
                $response = 'お問い合わせメール送信が失敗しました。';
            } else {
                $response = 'お問い合わせメール送信が成功しました。';
            }
        } catch(\Exception $e) {
            $response = 'お問い合わせメール送信が失敗しました。';
        }

        $ret = [];
        $ret['flash_message'] = $response;
        $ret['title'] = $record['title'];
        $ret['email'] = $record['email'];
        $ret['content'] = $record['content'];

        Session::put('ret', $ret);
        return redirect()->back()
            ->with('ret', $ret);
    }
}
