<?php
namespace Services\Activityalerts;

use Illuminate\Support\Facades\Config;
use Aws\Sns\SnsClient;
/**
 * Our NotifierAwsSnsService, containing all useful methods for business logic around Notifiers
 */
class NotifierAwsSnsService
{
	
	public function notify($recipients, $event) {
		$snsClient = SnsClient::factory ( array ('profile' => 'default', 'region' => 'us-east-1', 'key' => 'YOUR_AWS_ACCESS_KEY_ID', 'secret' => 'YOUR_AWS_SECRET_ACCESS_KEY', ) );
		$failedToSendNotification = false;
		try{
			$result = $snsClient->publish(array(
			    'TopicArn' => 'arn:aws:sns:us-east-1:745215811653:FailedCreditCardTest',
			    // Message is required
			    'Message' => $event->event_data,
			    'Subject' => 'Event Alert for type ' . $event->event_type_code . ' Event Id: ' . $event->id,
			));
			
			$eventNotificationLog = new \EventNotificationLog();
			$eventNotificationLog->event_id = $event->id;
			$eventNotificationLog->log_type = 'Info';
			$eventNotificationLog->log_message = 'Text message was sent successfully. Message Id is:  ' . $result->get('MessageId');
			$eventNotificationLog->save();
			
		} catch (Exception $e) {
			$eventNotificationLog = new \EventNotificationLog();
			$eventNotificationLog->event_id = $event->id;
			$eventNotificationLog->log_type = 'Error';
			$eventNotificationLog->log_message = 'Text message failed to be sent. Exception message is: ' . $e->getMessage();
			$eventNotificationLog->save();
			$failedToSendNotification = true;
		}
				
		if ($failedToSendNotification) {
			return false;
		} 
		return true;
	}
}