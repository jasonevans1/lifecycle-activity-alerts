<?php


class NotificationRuleTableSeeder extends Seeder {

	public function run()
	{
		DB::table('notification_rules')->delete();

		NotificationRule::create(array(
		'name' => 'Default Notification Rule',
		'conditions' => '{"event_type_code":"DefaultType", "message_severity":"Critical"}',
		'actions' => '{"recipient_id":"1", "notifier_code":"AWS_SES_EMAIL"}'
		));

	}

}
