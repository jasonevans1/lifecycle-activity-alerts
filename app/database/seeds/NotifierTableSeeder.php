<?php


class NotifierTableSeeder extends Seeder {

	public function run()
	{
		DB::table('notifiers')->delete();

		Notifier::create(array(
		'notifier_code' => 'AWS_SES_EMAIL',
		'notifier_class' => ''
		));

	}

}
