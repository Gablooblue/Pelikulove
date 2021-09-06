<?php

namespace App\Http\Controllers;

class SubmissionController2 extends Controller
{    
    public function index()
    {  
        //
	}
	
    public function getSubStoragePath ($id, $file) {
		$path = storage_path('app/'  . 'submissions/' . $id .'/'. $file);
		return response()->file($path);
	}
}
