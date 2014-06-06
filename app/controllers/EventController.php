<?php

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

class EventController extends BaseController {

	public function index()
	{
		
		$events = EventData::all()->take(50);
		if (is_null($events)) {
			return Response::json(array('error' => true, 'message' => 'No Events were found.'), 404);
		}
		
		return Response::json(array(
				'error' => false,
				'events' => $events->toArray()),
				200
		);
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
			
			$event = new EventData();
			$event->message_severity = Input::get('message_severity');
			$publisherCode = Input::get('publisher_code');
			$typeCode = Input::get('type_code');
			$eventData = Input::get('event_data');
			
			$publishers = DB::table('event_publishers')->where('publisher_code', '=', $publisherCode)->get();
			$publisherId = null;
			foreach ($publishers as $publisher)
			{
				$publisherId = $publisher->id;
			}
			if (is_null($publisherId)) {
				return Response::json(array('error' => true, 'message' => 'Publisher Code does not exist.'), 400);
			}
			if (is_null($typeCode)) {
				return Response::json(array('error' => true, 'message' => 'Event Type Code is required.'), 400);
			}
			if (is_null($eventData)) {
				return Response::json(array('error' => true, 'message' => 'Event Data is required.'), 400);
			}
				
			$event->event_publisher_id = $publisherId;
			$event->event_type_code = $typeCode;
			
			$event->event_data = json_encode($eventData);
			
			$event->save();
			
			NotificationRulesProcessor::processRule($event,'api');
			return Response::json(array('error' => false,'event' => $event->toArray()),200);
	}
	
	public function show($id) {
		$event = EventData::find($id);
		if (is_null($event)) {
			return Response::json(array('error' => true, 'message' => 'Event was not found.'), 404);
		}
		return Response::json(array('error' => false,'event' => $event->toArray()),200);
	}
	
}
