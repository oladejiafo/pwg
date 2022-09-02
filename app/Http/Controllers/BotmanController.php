<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Incoming\Answer;

class BotmanController extends Controller
{
    public function enterRequest()
    {
        $botman = app('botman');

        $botman->hears('{message}', function($botman, $message) {
            if($message == "Hi! I need your help") {
                $this->askName($botman);
            } else {
                $botman->reply("Hello! How can I help you?");
            }
        });

        $botman->listen();
    }

    public function askReply($botman) {
        $botman->ask('Hello! What is your name?', function(Answer $answer){
            $name = $answer->getText();
            $this->say('Nice to meet you ' . $name);
        });
    }
}
