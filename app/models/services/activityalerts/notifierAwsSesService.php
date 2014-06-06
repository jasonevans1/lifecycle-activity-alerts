<?php
namespace Services\Activityalerts;

use Aws\Ses\SesClient;
use Illuminate\Support\Facades\Config;
/**
 * Our NotifierAwsSesService, containing all useful methods for business logic around Notifiers
 */
class NotifierAwsSesService
{
	
	public function notify($recipients, $event) {
		$sesClient = SesClient::factory ( array ('profile' => 'default', 'region' => 'us-east-1', 'key' => 'YOUR_AWS_ACCESS_KEY_ID', 'secret' => 'YOUR_AWS_SECRET_ACCESS_KEY', ) );
		
		foreach ($recipients as $recipient)
		{
			$emailAddress = $recipient->email;
			
			//Now that you have the client ready, you can build the message
			$msg = array();
			$msg['Source'] = 'evans022@gmail.com';
			//ToAddresses must be an array
			$msg['Destination']['ToAddresses'][] = $emailAddress;
			
			$msg['Message']['Subject']['Data'] = 'Event Alert for type ' . $event->event_type_code;
			$msg['Message']['Subject']['Charset'] = "UTF-8";
			
			$msg['Message']['Body']['Text']['Data'] = $event->event_data;
			$msg['Message']['Body']['Text']['Charset'] = "UTF-8";
			
			try{
				$verifiedEmailAddressesResponse = $sesClient->listVerifiedEmailAddresses();
				$verifiedEmailAddresses = $verifiedEmailAddressesResponse['VerifiedEmailAddresses'];
				if (array_search($emailAddress, $verifiedEmailAddresses) === false) {
					$result = $sesClient->verifyEmailIdentity(array(
							'EmailAddress' => $emailAddress,
					));
					$eventNotificationLog = new \EventNotificationLog();
					$eventNotificationLog->event_id = $event->id;
					$eventNotificationLog->log_type = 'Info';
					$eventNotificationLog->log_message = 'Verify Email Identity was sent';
					$eventNotificationLog->save();
					return false;
				}
				$result = $sesClient->sendEmail($msg);
				
				$eventNotificationLog = new \EventNotificationLog();
				$eventNotificationLog->event_id = $event->id;
				$eventNotificationLog->log_type = 'Info';
				$eventNotificationLog->log_message = 'Email was sent successfully. Message Id is:  ' . $result->get('MessageId');
				$eventNotificationLog->save();
				return $result->get('MessageId');
			} catch (Exception $e) {
				$eventNotificationLog = new \EventNotificationLog();
				$eventNotificationLog->event_id = $event->id;
				$eventNotificationLog->log_type = 'Error';
				$eventNotificationLog->log_message = 'Email failed to be sent. Exception message is: ' . $e->getMessage();
				$eventNotificationLog->save();
				return false;
			}
				
		}
	}
}