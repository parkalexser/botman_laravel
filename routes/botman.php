<?php
use App\Http\Controllers\BotManController;
use BotMan\Drivers\Telegram\Extensions\Keyboard;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton;

$botman = resolve('botman');
// $botman = app('botman');


$botman->hears('foo', function($bot){
	$bot->reply('Hello');
	$bot->ask('Hello! What is your firstname?', function(Answer $answer) {
    // Save result
    // $this->firstname = $answer->getText();

    // $this->say('Nice to meet you '.$this->firstname);
    // $this->askEmail();
});
	
});

$botman->hears('info', function ($bot) {
    $bot->startConversation(new \App\Conversations\MyConversation());
});

$botman->hears('Start conversation', BotManController::class.'@startConversation');






?>