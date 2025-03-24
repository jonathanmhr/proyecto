<?php

// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(10);

        dd($users); // Depuración: Verifica si los usuarios están llegando

        return view('dashboard', compact('users'));
    }
}