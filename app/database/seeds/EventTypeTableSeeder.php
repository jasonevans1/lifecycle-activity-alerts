<?php


class EventTypeTableSeeder extends Seeder {

	public function run()
	{
		DB::table('event_types')->delete();

		EventType::create(array(
		'type_code' => 'DefaultType'
		));

	}

}
