<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
// use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class AdminLoginController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->passes()) {
            if (Auth::guard('admin')->attempt([
                'email' => $request->email,
                'password' => $request->password,
            ], $request->get('remember'))) {

                $admin = Auth::guard('admin')->user();
                if ($admin->role == 1) {
                    // dd($admin->role);
                    return redirect()->route('admin.dashboard');
                } else {

                    Auth::guard('admin')->logout();
                    return redirect()->route('admin.login')->with('error', "Your are not authorized to access admin panel.");
                }
            } else {
                // dd(11);
                return redirect()->route('admin.login')->with('error', 'Eiter Email/Password is incorrect ');
            }
        } else {
            // dd(12);
            return redirect()->route('admin.login')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
