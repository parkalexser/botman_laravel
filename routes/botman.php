<?php
use App\Http\Controllers\BotManController;
use BotMan\Drivers\Telegram\Extensions\Keyboard;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton;
use BotMan\BotMan\Messages\Attachments\Audio;

$botman = resolve('botman');
// $botman = app('botman');


$botman->receivesAudio(function ($bot, $audios){
//    $bot->reply(\BotMan\BotMan\Messages\Outgoing\OutgoingMessage::create('I received')->withAttachment($audio[0]));
    foreach ($audios as $audio) {

//        $url = $audio->getUrl(); // The direct url
//        $payload = $audio->getPayload(); // The original payload
        $bot->reply('url-'.$audio->getUrl().'payload-'.$audio->getPayload());
    }
});


$botman->hears('hi', function($bot){
	$bot->reply('Hello!');
	$bot->ask('What is your name', function ($answer, $conversation){
        $conversation->say('Thank you '. $answer->getText());
    },
        Keyboard::create()->type( Keyboard::TYPE_KEYBOARD )
           ->oneTimeKeyboard(true)
           ->resizeKeyboard(true)
           ->addRow(
               KeyboardButton::create("Send contact")->callbackData('contact')->requestContact(true)
           )
           ->toArray()
    );
});

$botman->hears('info', function ($bot) {
    $bot->startConversation(new \App\Conversations\MyConversation());
});

$botman->hears('Start conversation', BotManController::class.'@startConversation');

//,
//Keyboard::create()->type( Keyboard::TYPE_KEYBOARD )
//    ->oneTimeKeyboard(true)
//    ->addRow(
//        KeyboardButton::create("Да")->callbackData('first_inline'),
//        KeyboardButton::create("Нет")->callbackData('second_inline'),
//        KeyboardButton::create("Не знаю")->callbackData('third_inline')
//    )
//    ->toArray()


?>
