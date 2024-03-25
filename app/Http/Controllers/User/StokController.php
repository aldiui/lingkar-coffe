<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class StokController extends Controller
{
    public function index()
    {
        return view('pages.user.stok.index');
    }
}
