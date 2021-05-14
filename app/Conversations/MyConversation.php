<?php

namespace App\Conversations;

use BotMan\BotMan\Facades\BotMan;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Attachments\File;


class MyConversation extends Conversation
{
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->say('Hello!');
        $this->askForContact('send contacts', function($contact) {
            $phone = $contact->getPhoneNumber();
            $this->say('Thank you! Your phone is '.$phone);
        });
        // $this->say('hhh');
        // $this->askForImages('send photo', function( $images ) {
        //     foreach ($images as $image) {
        //         $url = $image->getUrl(); // The direct url
        //         $title = $image->getTitle(); // The title, if available
        //         $payload = $image->getPayload(); // The original payload
        //         $this->say($url);
        //     }
        // });

//        $question = Question::create('Get info?')
//            ->addButtons([
//                Button::create('Yes')->value(1),
//                Button::create('No')->value(0),
//            ]);
//
//        $this->ask($question, function ($answer){
//
//            if($answer->getValue() == 1){
//                $user = $this->bot->getUser();
//                $this->say(print_r($user->getInfo(), true));
//            }else{
//                $this->say('you pressed - '.$answer->getValue());
//            }
//
//        });
    }
}


