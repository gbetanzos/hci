<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Incoming\Answer;

class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');

        $botman->hears('{message}', function($botman, $message) {
   
            if ($message == 'hi') {
                $botman->reply("How are you doing ?");#$this->askName($botman);
            }elseif(preg_match("/.*setup.*monitor.*/", $message)){
                $botman->reply('Perfect lets do that ... please provide a hostname followed by a port like this: google.com:80');
            }elseif(preg_match("/.*(?!\-)(?:(?:[a-zA-Z\d][a-zA-Z\d\-]{0,61})?[a-zA-Z\d]\.){1,126}(?!\d+)[a-zA-Z\d]{1,63}:[0-9]+.*/", $message)){
                $botman->reply('Setting this up ...');
            }elseif(strtolower($message)=="no"){
                $arr=["If things change the invitation is open","I really want to catch up so let me know a good time","No matter, we'll catch up another time","bugger I was really looking forward to this, you've ruined my night now, I hope you're happy"];
                $n=rand(0,3);
                $botman->reply($arr[$n]);
            }else{
                $botman->reply("What about helping you setup a monitor...");
            }
        });

        #$botman->hears('.*setup.*monitor.*', function ($bot) {
        #    $bot->reply('Perfect lets do that ... please provide a hostname followed by a port like this: google.com:80');
        #});

        #$botman->hears("^((?!-)[A-Za-z0-9-]{1, 63}(?<!-)\\.)+[A-Za-z]{2, 6}:[0-9]+$", function ($bot) {
        #    $bot->reply('Setting this up ...');
        #});
        

        $botman->listen();
    }
   
    /**
     * Place your BotMan logic here.
     */
    public function askName($botman)
    {
        $botman->ask('Hello! What is your Name?', function(Answer $answer) {
            $name = $answer->getText();
            $this->say('Nice to meet you '.$name);
        });
    }
}
