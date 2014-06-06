<?php


class EventPublisherTableSeeder extends Seeder {

	public function run()
	{
		DB::table('event_publishers')->delete();

		EventPublisher::create(array(
		'name' => 'Default API Publisher',
		'publisher_code' => 'DefaultPublisher'
		));

	}

}
