<?php

namespace App\Conversations;

use BotMan\BotMan\Facades\BotMan;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\Drivers\Telegram\Extensions\Keyboard;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton;

class MainConversation extends Conversation
{
	/**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
    	$this->say('Hello! Welcome to appointment BOT!:hear_no_evil:');
        Keyboard::create()->type( Keyboard::TYPE_KEYBOARD )
           ->oneTimeKeyboard(true)
           ->resizeKeyboard(true)
           ->addRow(
               KeyboardButton::create("Language")->callbackData('language')
           )
           ->toArray();

    }
}