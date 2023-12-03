<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class HomeController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
        $admin = Auth::guard('admin')->user();
        if ($admin == null) {
            return redirect()->route('admin.login');
        }

        echo 'welcome ' . $admin->name . '<a href="' . route('admin.logout') . '">Logout</a>';
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
