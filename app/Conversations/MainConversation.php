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
    	$this->mainAsk();
    }

    private function mainAsk(){
        $this->ask('Hello! Welcome to appointment BOT!', function ($response) {

                if($response->getText() === 'Language'){
                    // $this->say('Set your ' . $response->getText());
                    // $this->say('Cool - you callback ' . $response->getValue());
                    // $this->setLang();


                }elseif($response->getText() === "Settings"){
                    $this->chooseSettings();
                }

            },
            $this->mainKeyboard()
        );
    }

    private function chooseSettings(){
        $this->ask('Here you can setting your profile', function($responseSettings){
            if($responseSettings->getText() === 'Language'){
                $this->setLang();
            }elseif($responseSettings->getText() == 'Back'){
                $this->mainAsk();
            }

        }, $this->settingKeyboard() );
    }

    private function setLang()
    {
    	// $question = Question::create("Choose language"."\u{1F1F7}\u{1F1FA}"." / "."\u{1F1FA}\u{1F1F8}"." / "."\u{1F1FA}\u{1F1FF}")
     //        ->fallback('Unable to ask question')
     //        ->callbackId('ask_reason')
     //        ->addButton(
     //            Button::create('Ozbek')->value('ozb'),
     //        )
     //        ->addButtons([
     //            Button::create('Русский')->value('rus'),
     //            Button::create('English')->value('eng'),
     //        ]);


        $this->ask('Set your language', function (Answer $answer) {

            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === 'rus') {
                    $this->say('Вы выбрали русский язык');
                    $this->setLang();
                } elseif($answer->getValue() === 'eng') {
                    $this->say('You choice is English');
                    $this->setLang();
                } elseif($answer->getValue() === 'ozb') {
                    $this->say('Ozbekcha');
                    $this->setLang();
                }
            }
        }, $this->inlineKeyboard() );
    }



    // Keyboards
    private function mainKeyboard()
    {
    	return Keyboard::create()->type( Keyboard::TYPE_KEYBOARD )
			->oneTimeKeyboard(false)
			->resizeKeyboard(true)
            ->addRow(
                KeyboardButton::create("Book")->callbackData('book')
            )
            ->addRow(
                KeyboardButton::create("My favorite")->callbackData('my_favorite')
            )
			->addRow(
                KeyboardButton::create("Settings")->callbackData('settings')
       		)
            ->toArray();
    }

    private function settingKeyboard()
    {
        return Keyboard::create()->type( Keyboard::TYPE_KEYBOARD )
            ->oneTimeKeyboard(false)
            ->resizeKeyboard(true)
            ->addRow(
                KeyboardButton::create("Back")->callbackData('back'),
                KeyboardButton::create("Language")->callbackData('language')
            )
            ->toArray();
    }

    private function inlineKeyboard()
    {
        return Keyboard::create()->type( Keyboard::TYPE_INLINE )
            ->oneTimeKeyboard(true)
            ->resizeKeyboard(true)
            ->addRow(
                KeyboardButton::create("\u{1F1F7}\u{1F1FA}")->callbackData('rus'),
                KeyboardButton::create("\u{1F1FA}\u{1F1F8}")->callbackData('eng'),
                KeyboardButton::create("\u{1F1FA}\u{1F1FF}")->callbackData('ozb')
            )
            ->toArray();
    }
}