<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use App\Conversations\ExampleConversation;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Carbon\CarbonInterval;

class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');

        $botman->listen();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tinker()
    {
        return view('botman');
    }

    /**
     * Loaded through routes/botman.php
     * @param  BotMan $bot
     */
    public function startConversation(BotMan $bot)
    {
        $bot->startConversation(new ExampleConversation());
    }

    public function test(int $month = 5, int $year = 2021){
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

        dd($calendarMap);
    }
}
