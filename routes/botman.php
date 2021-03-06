<?php
use App\Http\Controllers\BotManController;
use BotMan\Drivers\Telegram\Extensions\Keyboard;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton;
use BotMan\BotMan\Messages\Attachments\Audio;
use BotMan\BotMan\Messages\Attachments\File;
use BotMan\BotMan\Messages\Attachments\Image;

$botman = resolve('botman');
// $botman = app('botman');

$botman->hears('/start', function ($bot) {
    $bot->startConversation(new \App\Conversations\MainConversation());
});


// $botman->receivesImages(function($bot,$images) {
//     foreach ($images as $image) {

//         $url = $image->getUrl(); // The direct url
//         $title = $image->getTitle(); // The title, if available
//         $payload = $image->getPayload(); // The original payload
//         $bot->reply($url);
//     }
// });

// $botman->receivesContact(function($bot, $contact) {
//     $phone = $contact->getPhoneNumber();
//     $bot->reply('Thank you! Your phone is '.$phone);
// });



$botman->hears('hi', function($bot){
	$bot->reply('Hello!');
// 	$bot->ask('What is your name', function ($answer, $conversation){


//     },
//         Keyboard::create()->type( Keyboard::TYPE_KEYBOARD )
//            ->oneTimeKeyboard(true)
//            ->resizeKeyboard(true)
//            ->addRow(
//                KeyboardButton::create("Send contact")->callbackData('contact')->requestContact(true)
//            )
//            ->toArray()
//     );
});

$botman->hears('my', function ($bot) {
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
