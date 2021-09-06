<?php

namespace App\Http\Controllers;

use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;
use Carbon\Carbon;

class SEOController extends Controller
{
  public function generate()
  {  
    // $url = url('redirector/2');
		SitemapGenerator::create(url('/'))
    ->hasCrawled(function (Url $url) {
      // if ($url->segment(2) == 'redirector') {
      //     return;
      // }

      return $url;
    })->writeToFile(public_path().'/sitemap.xml'); 
		return redirect('/sitemap.xml');
	}
	
  public function create()
  {
      //
	}

  public function store(Request $request)
  {
  //
  }
}