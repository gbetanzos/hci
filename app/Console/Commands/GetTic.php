<?php

namespace App\Console\Commands;

use App\Models\Monitor;
use App\Models\Tic;
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
            $time_start = microtime(true);
            if($m->port==443){
                $url = "https://".$m->host;
            }else{
                $url = "http://".$m->host;
            }
            
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
            curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_PORT , $m->port);
            curl_setopt($ch, CURLOPT_TIMEOUT,10);
            $output = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            print("==========================================================\n");
            print("Host: ".$m->host." | Code: $httpcode | Port: ".$m->port."\n");
            $time_end = microtime(true);
            $time = $time_end - $time_start;
            print("Seconds: $time\n");
            $t=new Tic();
            $t->status=$httpcode;
            $t->time=$time;
            $t->monitor_id=$m->id;
            $t->save();

        }
        return 0;
    }
}
