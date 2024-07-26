<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        $user = User::count();
        $role = auth()->user()->role;

        if ($role == 'SuperAdmin') {
            return view('dashboard', compact('user'));
        } elseif ($role == 'Users') {
            return view('users-dashboard', compact('user'));
        }

        abort(403, 'Unauthorized action.');
    }
    
}
