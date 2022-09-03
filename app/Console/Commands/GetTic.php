<?php

namespace App\Console\Commands;

use App\Models\Monitor;
use Illuminate\Console\Command;

class GetTic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:tic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Tics from a service';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        foreach(Monitor::all() as $m){
            #dd($m);
            print($m->host);
        }
        return 0;
    }
}
