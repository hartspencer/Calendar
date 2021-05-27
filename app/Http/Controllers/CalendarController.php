<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendar;

class CalendarController extends Controller
{

	public function getEventInfo(){
		$event = Calendar::first();

		if(!$event){
			$event = new Calendar();
		}

		return view('welcome')->withEvent($event);
	}
    public function createEvent(Request $request){

	Calendar::truncate();

    $date_start = $request->from;
    $date_end = $request->to;

    while($date_start <= $date_end){

			$day = date('D', strtotime($date_start));
			$insert_event = false;

			if($day == 'Mon' && isset($request->mon)){
				$insert_event = true;
			}elseif ($day == 'Tue' && isset($request->tue)) {
				$insert_event = true;
			}elseif ($day == 'Wed' && isset($request->wed)) {
				$insert_event = true;
			}elseif ($day == 'Thu' && isset($request->thu)) {
				$insert_event = true;
			}elseif ($day == 'Fri' && isset($request->fri)) {
				$insert_event = true;
			}elseif ($day == 'Sat' && isset($request->sat)) {
				$insert_event = true;
			}elseif ($day == 'Sun' && isset($request->sun)) {
				$insert_event = true;
			}

			if($insert_event){
				$calendar_event = new Calendar();
	   			$calendar_event->name = $request->name;
	   			$calendar_event->start = $date_start;

				$date_start = date("Y-m-d", strtotime("+1 day", strtotime($date_start)));
	   			$calendar_event->end = $date_start;
	   			$calendar_event->color = '#6aa84f';
	   			$calendar_event->save();
			}else{
				$date_start = date("Y-m-d", strtotime("+1 day", strtotime($date_start)));
				continue;
			}
    }

    return redirect()->back()->withSuccess('Event has been saved!');

    }
}
