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
            if($m->port==80 ||$m->port==443){
                $ch = curl_init();
                // set url
                curl_setopt($ch, CURLOPT_URL, "example.com");
                //return the transfer as a string
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                // $output contains the output string
                $output = curl_exec($ch);
                // close curl resource to free up system resources
                curl_close($ch);     
                //print($m->host);
                print($output);
            }
        }
        return 0;
    }
}
