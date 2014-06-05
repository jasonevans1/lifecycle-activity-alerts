<?php

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

class EventController extends BaseController {

	public function index()
	{
		return 'Hello, API';
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
			
			$event = new EventData();
			$event->message_type = Input::get('message_type');
			$publisherCode = Input::get('publisher_code');
			$typeCode = Input::get('type_code');
			
			$publishers = DB::table('event_publishers')->where('publisher_code', '=', $publisherCode)->get();
			$publisherId = null;
			foreach ($publishers as $publisher)
			{
				$publisherId = $publisher->id;
			}
			if (is_null($publisherId)) {
				return Response::json(array('error' => true, 'message' => 'Publisher Code does not exist.'), 400);
			}
			$eventTypes = DB::table('event_types')->where('type_code', '=', $typeCode)->get();
			$eventTypeId = null;
			foreach ($eventTypes as $eventType)
			{
				$eventTypeId = $eventType->id;
			}
			if (is_null($eventTypeId)) {
				return Response::json(array('error' => true, 'message' => 'Event Type Code does not exist.'), 400);
			}
				
			$event->event_publisher_id = $publisherId;
			$event->event_type_id = $eventTypeId;
			
			$eventData = Input::get('event_data');
			$event->event_data = json_encode($eventData);
			
			$event->save();
			
			return Response::json(array('error' => false,'event' => $event->toArray()),200);
	}
}
