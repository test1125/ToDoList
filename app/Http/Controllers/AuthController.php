<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }
    
    public function login(Request $request)
    {
        //バリデーション
        $credentials = $request->validate([
            'name' => ['required'],
            'password' => ['required']
        ]);

        //ログイン情報の検証
        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        //ログイン情報が間違っているとき
        return back()->withErrors([
            'name'=>'ユーザー名またはパスワードが正しくありません'
        ])->onlyInput('name');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
