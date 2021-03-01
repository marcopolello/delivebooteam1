<?php

namespace App\Http\Controllers;
use App\Plate;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
      $plate_data = Plate::all();
      // mettere where visible : 1
      // dd($plate_data);
      return view('welcome', compact('plate_data'));
    }
}
