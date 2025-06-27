<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    //for the welcome page laravel default
    public function index()
    {
        return view('welcome');
    }
}
