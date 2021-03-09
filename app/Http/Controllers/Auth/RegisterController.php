<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
// aggiunte 3/03/21
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        // dd($data);
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'address' => ['required', 'string', 'max:255'],
            'piva' => ['required', 'string', 'min:11', 'max:11'],
            'phone' => ['required', 'string', 'min:6', 'max:30'],
            'delivery_cost_euro' => ['required', 'integer', 'min:0', 'max:9999'],
            'delivery_cost_cent' => ['required', 'integer', 'min:0', 'max:99'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $deliveryCost = $data['delivery_cost_euro'] . $data['delivery_cost_cent'];
        // dd($data);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'address' => $data['address'],
            'piva' => $data['piva'],
            'phone' => $data['phone'],
            'delivery_cost' => $deliveryCost,
        ]);
        Mail::to($data['email'])->send(new SendMail($user));

        return $user;

    }

}
