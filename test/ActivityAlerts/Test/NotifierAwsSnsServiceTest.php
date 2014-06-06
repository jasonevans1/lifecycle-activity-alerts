<?php

namespace ActivityAlerts\Test;

use Services\Activityalerts\NotifierAwsSnsService;

class NotifierAwsSnsServiceTest extends \TestCase {
	public function setUp() {
		parent::SetUp ();
	}
	public function testNotifyWithOneRecipient() {
		$event = \EventData::find ( 1 );
		$recipient = \Recipient::all ()->take ( 1 );
		$service = new NotifierAwsSnsService ();
		$this->assertTrue ( $service->notify ( $recipient, $event ) );
	}
}
