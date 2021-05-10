<?php
use App\Http\Controllers\BotManController;

$botman = resolve('botman');
// $botman = app('botman');


$botman->hears('foo', function($bot){
	$bot->reply('bar');
});

$botman->hears('info', function ($bot) {
    $bot->startConversation(new \App\Conversations\MyConversation());
});

$botman->hears('Start conversation', BotManController::class.'@startConversation');

?>