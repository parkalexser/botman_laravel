<?php
use App\Http\Controllers\BotManController;
use BotMan\Drivers\Telegram\Extensions\Keyboard;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton;

$botman = resolve('botman');
// $botman = app('botman');


$botman->hears('hi', function($bot){
	$bot->reply('Hello');
	$bot->ask('What is your name', function ($answer, $conversation){
        $conversation->say('Nice to meet you '.$answer->getText());
    },
        Keyboard::create()->type( Keyboard::TYPE_KEYBOARD )
        ->oneTimeKeyboard(true)
        ->addRow(
            KeyboardButton::create("Да")->callbackData('first_inline'),
            KeyboardButton::create("Нет")->callbackData('second_inline')
        )
        ->toArray()
    );
});

$botman->hears('info', function ($bot) {
    $bot->startConversation(new \App\Conversations\MyConversation());
});

$botman->hears('Start conversation', BotManController::class.'@startConversation');






?>