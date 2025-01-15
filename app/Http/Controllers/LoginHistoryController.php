<?php

namespace App\Http\Controllers;

use App\Models\LoginHistory; // Mengimpor model LoginHistory
use Illuminate\Http\Request;

class LoginHistoryController extends Controller
{
    public function showLoginHistory()
    {
        // Mengambil semua data login history
        $loginHistory = LoginHistory::with('user')->get(); // Mengambil semua data login dari tabel login_history

        // Mengirim data ke view
        return view('login-history', compact('loginHistory')); // Mengirim data login ke view login-history.blade.php
    }
}
