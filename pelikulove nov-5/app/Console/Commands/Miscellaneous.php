<?php

namespace App\Console\Commands;

use Auth;

use App\Models\Vod;
use App\Models\User;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;

class Miscellaneous extends Command
{
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'misc:todos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs every x to check for to dos';

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
        
    }
}
