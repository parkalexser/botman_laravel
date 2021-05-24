<?php

namespace App\Conversations;

use BotMan\BotMan\Facades\BotMan;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\Drivers\Telegram\Extensions\Keyboard;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Carbon\CarbonInterval;

use App\Calendar;

class MainConversation extends Conversation
{
	/**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->say('Welcome to appointment BOT!');
    	$this->mainAsk();
    }

    private function mainAsk()
    {
        $this->ask('Choose your option', function ($response) {

                if($response->getText() === 'Book'){
                    $this->getCalendar();
                }elseif($response->getText() === "My favorite"){

                }elseif($response->getText() === "Settings"){
                    $this->chooseSettings();
                }
                elseif ($response->getText() === 'calendar') {
                    $this->calendar();
                }

            },
            $this->mainKeyboard()
        );
    }


    private function chooseSettings()
    {
        $this->ask('Here you can setting your profile', function($responseSettings){
            if($responseSettings->getText() === 'Language'){
                $this->setLang();
            }elseif($responseSettings->getText() == 'Master profile'){
                $this->say('Here you can become a master');
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

            // if ($answer->isInteractiveMessageReply()) {

                if ($answer->getValue() === 'rus') {
                    $this->say('Вы выбрали русский язык');
                    $this->chooseSettings();
                } elseif($answer->getValue() === 'eng') {
                    $this->say('You choice is English');
                    $this->chooseSettings();
                } elseif($answer->getValue() === 'ozb') {
                    $this->say('Ozbekcha');
                    $this->chooseSettings();
                } elseif($answer->getText() === 'Back') {
                    $this->mainAsk();
                }
            // }
        }, $this->inlineKeyboard() );
    }

    private function getCalendar(){
         $this->ask('Choose calendar', function (Answer $answer) {
            $this->say(print_r($answer->getCallbackId(), true));
            // $this->say(print_r($this->bot->getBotMessages()[0], true));
            // $this->say($answer->getMessage()->getPayload()['message_id']);

        }, Calendar::create()->type( Keyboard::TYPE_INLINE )
            ->oneTimeKeyboard(false)
            ->resizeKeyboard(true)
            ->addRow(
                $this->calendar()
            )
            ->toArray()
        );
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
            ->addRow(
                KeyboardButton::create("Master profile")->callbackData('master_profile')
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

    private function calendar(int $month = 5, int $year = 2021){
        // printf("Now: %s", Carbon::now());
        // exit;
        $prevMonthCallback = 'calendar-month-';
        if ($month === 1) {
            $prevMonthCallback .= '12-'.($year-1);
        } else {
            $prevMonthCallback .= ($month-1).'-'.$year;
        }

        $nextMonthCallback = 'calendar-month-';
        if ($month === 12) {
            $nextMonthCallback .= '1-'.($year+1);
        } else {
            $nextMonthCallback .= ($month+1).'-'.$year;
        }

        $start = new Carbon(sprintf('%d-%d-01', $year, $month));

        $calendarMap = [
            [
                ['text' => '<', 'callback_data' => $prevMonthCallback],
                ['text' => $start->format('F Y'), 'callback_data' => 'calendar-months_list-'.$year],
                ['text' => '>', 'callback_data' => $nextMonthCallback],
            ],
            [
                ['text' => 'Mon', 'callback_data' => 'null_callback'],
                ['text' => 'Tue', 'callback_data' => 'null_callback'],
                ['text' => 'Wed', 'callback_data' => 'null_callback'],
                ['text' => 'Thu', 'callback_data' => 'null_callback'],
                ['text' => 'Fri', 'callback_data' => 'null_callback'],
                ['text' => 'Sat', 'callback_data' => 'null_callback'],
                ['text' => 'Sun', 'callback_data' => 'null_callback'],
            ],
        ];


        $end = clone $start;
        $end->modify('last day of this month');
        $iterEnd = clone $start;
        $iterEnd->modify('first day of next month');
        $row = 2;
        foreach (new CarbonPeriod($start, new CarbonInterval("P1D"), $iterEnd) as $date) {
            /** @var \DateTime $date */

            if (!isset($calendarMap[$row])) {
                $calendarMap[$row] = array_combine([1, 2, 3, 4, 5, 6, 7], [[], [], [], [], [], [], []]);
            }

            $dayIterator = (int)$date->format('N');
            if ($dayIterator != 1 && $start->format('d') === $date->format('d')) {
                for ($i = 1; $i < $dayIterator; $i++){
                    $calendarMap[$row][$i] = ['text' => ' ', 'callback_data' => 'null_callback'];
                }
            }

            $calendarMap[$row][$dayIterator] = ['text' => $date->format('d'), 'callback_data' => sprintf('calendar-day-%d-%d-%d', $date->format('d'), $month, $year)];

            if ($dayIterator < 7 && $end->format('d') === $date->format('d')) {
                for ($i = $dayIterator+1; $i <= 7; $i++){
                    $calendarMap[$row][$i] = ['text' => ' ', 'callback_data' => 'null_callback'];
                }
                $calendarMap[$row] = array_values($calendarMap[$row]);
                break;
            }

            if ($dayIterator === 7) {
                $calendarMap[$row] = array_values($calendarMap[$row]);
                $row++;
            }
        }

        return $calendarMap;
    }
}