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

        $user = Auth::user();

        // restituisco feedback dell'user
        $feedbacks = $user -> feedback;

        // restituisco email utente senza @provider etc
        $email_user = $user -> email;
        $word = '@';
        $mail_cut = substr($email_user, 0, strpos($email_user, $word));

        return view('dashboard', compact('mail_cut', 'feedbacks'));
    }

}
