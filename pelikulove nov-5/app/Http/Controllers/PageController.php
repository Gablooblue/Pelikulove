<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function privacy()
    {
        return view('privacy/index');
    }
    
    public function welcome()
    {
        return view('welcome');
    }
    
     public function promo1()
    {
        return view('/pages/promo1');
    }
    
     public function promo2()
    {
        return view('pages/promo2');
    }
}
