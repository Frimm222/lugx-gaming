<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminAuthController extends Controller
{

    public function showLoginForm()
    {
        if (Session::has('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $allowedPasswords = explode(',', env('ADMIN_PASSWORDS', ''));


        $request->validate([
            'password' => 'required|string',
        ]);
        if (in_array($request->password, $allowedPasswords)) {
            Session::put('admin_logged_in', true);
            Session::regenerate();

            return redirect()->route('admin.dashboard')
                ->with('success', 'Добро пожаловать в админ-панель');
        }

        return back()->withErrors(['password' => 'Неверный пароль']);
    }

    public function logout(Request $request)
    {
        Session::forget('admin_logged_in');
        Session::regenerateToken();

        return redirect('/admin/login')->with('success', 'Вы вышли из админ-панели');
    }
}
