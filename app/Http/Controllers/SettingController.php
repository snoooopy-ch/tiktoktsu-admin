<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index() {
        $settings = Setting::all()
            ->keyBy('name')
            ->toArray();
        return view('setting.index', [
            'setting'  => $settings,
        ]);
    }

    public function save(Request $request) {
        $this->validate($request, [
            'mail_to'       => 'required|email',
            'recent_count'  => 'required|numeric'
        ]);

        $params = $request->all();
        
        $settings = Setting::where('name', 'mail_to')->first();
        $settings->value = $params['mail_to'];
        $settings->save();

        $settings = Setting::where('name', 'recent_count')->first();
        $settings->value = $params['recent_count'];
        $settings->save();

        return redirect()->back()->with('flash_message', '設定値を変更しました。');
    }
}
