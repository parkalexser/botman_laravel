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

    	$this->ask('Hello! Welcome to appointment BOT!',
    		function ($response) {

    			if($response->getText() === 'Language'){
    				$this->say('Set your ' . $response->getText());
		        	// $this->say('Cool - you callback ' . $response->getValue());
    				$this->setLang();
    			}

		    },
	    	$this->mainKeyboard()
	    );

    }

    private function setLang()
    {
    	$question = Question::create("Choose language"."\u{1F1F7}\u{1F1FA}"." / "."\u{1F1FA}\u{1F1F8}"." / "."\u{1F1FA}\u{1F1FF}")
            ->fallback('Unable to ask question')
            ->callbackId('ask_reason')
            ->addButtons([
                Button::create('Русский')->value('rus'),
                Button::create('English')->value('eng'),
            ]);

        return $this->ask($question, function (Answer $answer) {

            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === 'rus') {
                    $this->say('Вы выбрали русский язык');
                } else {
                    $this->say('You choice is English');
                }
            }
        });
    }

    private function mainKeyboard()
    {
    	return Keyboard::create()->type( Keyboard::TYPE_KEYBOARD )
			->oneTimeKeyboard(true)
			->resizeKeyboard(true)
			->addRow(
                KeyboardButton::create("Booking")->callbackData('booking'),
				KeyboardButton::create("Language")->callbackData('language')
       		)
            ->toArray();
    }
}