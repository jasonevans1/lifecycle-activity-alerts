<?php

namespace ActivityAlerts\Test;

use Services\Activityalerts\NotifierAwsSesService;
use Services\Activityalerts\NotificationRulesService;
class NotificationRulesServiceTest extends \TestCase
{
	
	public function setUp(){
		parent::SetUp();
	}
	
    public function testProcessAnEvent()
    {
    	$event = \EventData::find(1);
        $service = new NotificationRulesService();
        $this->assertTrue($service->processRule($event));
    }
}
