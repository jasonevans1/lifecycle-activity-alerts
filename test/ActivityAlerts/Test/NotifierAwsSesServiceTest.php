<?php

namespace ActivityAlerts\Test;

use Services\Activityalerts\NotifierAwsSesService;
class NotifierAwsSesServiceTest extends \TestCase
{
	
	public function setUp(){
		parent::SetUp();
	}
	
    public function testNotifyWithOneRecipient()
    {
    	$event = \EventData::find(1);
    	$recipient = \Recipient::all()->take(2);
        $service = new NotifierAwsSesService();
        $this->assertTrue($service->notify($recipient,$event));
    }
}
