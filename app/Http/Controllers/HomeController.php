<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


// Get the currently authenticated user...
        $user = Auth::user();
        echo $user;
// Get the currently authenticated user's ID...
        $id = Auth::id();
        echo $id;
        return view('home');
    }
}
