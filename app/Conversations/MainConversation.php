<?php

namespace App\Conversations;

use BotMan\BotMan\Facades\BotMan;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\Drivers\Telegram\Extensions\Keyboard;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;

class MainConversation extends Conversation
{
	/**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
    	// $question = Question::create("Huh - you woke me up. What do you need?")
     //        ->fallback('Unable to ask question')
     //        ->callbackId('ask_reason')
     //        ->addButtons([
     //            Button::create('Tell a joke')->value('joke'),
     //            Button::create('Give me a fancy quote')->value('quote'),
     //        ]);


    	$this->ask('Hello! Welcome to appointment BOT!',
    		function (Answer $response) {
	        	$this->say('Cool - you said ' . $response->getText());
	        	$this->say('Cool - you callback ' . $response->getValue());
		    },
	    	$this->mainKeyboard()
	    );



    }

    private function mainKeyboard(){
    	return Keyboard::create()->type( Keyboard::TYPE_KEYBOARD )
			->oneTimeKeyboard(true)
			->resizeKeyboard(true)
			->addRow(
				KeyboardButton::create("Language")->callbackData('language')
       		)
            ->toArray();
    }
}