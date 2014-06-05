<?php


class EventPublisherTableSeeder extends Seeder {

	public function run()
	{
		DB::table('event_publishers')->delete();

		EventPublisher::create(array(
		'application_code' => 'DefaultApplication',
		'publisher_code' => 'DefaultPublisher'
		));

	}

}
