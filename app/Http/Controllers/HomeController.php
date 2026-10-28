<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\Service;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'services' => Service::orderBy('code')->take(4)->get(),
            'outlets' => Outlet::orderBy('id')->get(),
        ]);
    }
}
