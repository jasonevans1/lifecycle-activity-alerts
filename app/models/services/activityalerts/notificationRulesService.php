<?php
namespace Services\Activityalerts;

use Aws\Ses\SesClient;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
/**
 * Our NotificationRulesService, containing all useful methods for business logic around Notifiers
 */
class NotificationRulesService
{
	
	public function processRule($event,$type) {
		$notificationRules = \NotificationRule::all();
		foreach ($notificationRules as $notificationRule)
		{
			$ruleType = $notificationRule->rule_type;
			if ($ruleType != $type) {
				continue;
			}
			$conditions = $notificationRule->conditions;
			$conditions = json_decode($conditions);
			//loop on all the condition name/value.
			//get the value from the event for the condition key
			//if the condition value equals the event
			$qualifies = true; 
			foreach ($conditions as $key => $value) {
				$eventValue = $event->$key;
				if (strtoupper($value) != strtoupper($eventValue)) {
					$qualifies = false;
				}
			}
			
			if ($qualifies) {
				$ruleActions = $notificationRule->actions;
				$ruleActions = json_decode($ruleActions);
				
				$recipientIds = $ruleActions->recipient_id;
				$arrayOfRecipientIds = explode(',', $recipientIds);
				$recipients = DB::table('recipients')->whereIn('id', $arrayOfRecipientIds)->get();
				
				$notifierCode = $ruleActions->notifier_code;
				$notifier = \Notifier::where('notifier_code', '=', $notifierCode)->firstOrFail();
				$notifierAlias = $notifier->notifier_class;
				$notificationResult = $notifierAlias::notify($recipients,$event);
				if ($notificationResult !== false) {
					$event->status = 1;
					$event->save();
				}
			}
		}
	}

}