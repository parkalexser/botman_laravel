<?php

namespace App\Conversations;

use BotMan\BotMan\Facades\BotMan;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class MyConversation extends Conversation
{
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $question = Question::create('Get info?')
            ->addButtons([
                Button::create('Yes')->value(1),
                Button::create('No')->value(0),
            ]);

        $this->ask($question, function ($answer){
//            $this->say($answer->getValue());
            if($answer->getValue() == 1){
                $user = $this->bot->getUser();
                $this->say(print_r($user->getInfo(), true));
            }else{
                $this->say('you pressed - '.$answer->getValue());
            }

        });
    }
}
