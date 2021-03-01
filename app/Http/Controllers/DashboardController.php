<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
  
    public function dashboard() {

        $email_user = Auth::user()-> email;
        $word = '@';
        // restituisco email utente senza @provider etc
        $mail_cut = substr($email_user, 0, strpos($email_user, $word));
  
        return view('dashboard', compact('mail_cut'));
    }
}
