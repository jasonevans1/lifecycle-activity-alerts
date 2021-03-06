<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('EventPublisherTableSeeder');
		$this->call('EventTypeTableSeeder');
		$this->call('NotificationRuleTableSeeder');
		$this->call('NotifierTableSeeder');
	}

}
