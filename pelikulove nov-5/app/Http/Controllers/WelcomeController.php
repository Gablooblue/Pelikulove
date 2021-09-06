<?php

namespace App\Http\Controllers;

class WelcomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        //return view('welcome');
        return redirect()->route('public.home');
    }
    
    public function login()
    {
        return view('auth.login');
    }
}
