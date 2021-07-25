<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Hash;

class AdminController extends Controller
{
    function index() {
        return view('admin');
    }

    function passwordupdate(Request $request) {
        $user = Auth::user();
        $id = $user->id;

        // Validate name, email and password fields
        $this->validate($request, [
            'old_password'              => ['required', new MatchOldPassword],
            'password'                  => 'required|min:6',
            'password_confirm'          => 'required|same:password',
        ]);

        User::find(auth()->user()->id)->update([
            'password'          => Hash::make($request->password),
        ]);

        return redirect()->route('password')
            ->with('flash_message', 'パスワードが変更されました');
    }
}
