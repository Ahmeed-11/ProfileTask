<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function index()
    {
        //show profile page

        return view('Profile');
    }

    public function create()
    {
        //
    }


}
