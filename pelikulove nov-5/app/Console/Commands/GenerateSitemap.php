<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Spatie\Sitemap\SitemapGenerator;

class GenerateSitemap extends Command
{
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new sitemap using Spatie\Sitemap';

    /**
     * Create a new command instance.
     *
     * DeleteExpiredActivations constructor.
     *
     * @param ActivationRepository $activationRepository
     */
    public function __construct()
    {
        parent::__construct();
       
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $log = Carbon::now()->toDateTimeString() . " - ";
        SitemapGenerator::create('https://learn.pelikulove.com/')->writeToFile(public_path().'/sitemap.xml'); 
        echo Carbon::now()->toDateTimeString() . ": Sitemap Generated \n";    
    }
}
