<?php
namespace Services\Activityalerts;

use \Illuminate\Support\Facades\Facade;

/**
 * Facade class to be called whenever the class NotifierService is called
 */
class NotifierAwsSnsFacade extends Facade {

	/**
	 * Get the registered name of the component. This tells $this->app what record to return
	 * (e.g. $this->app[‘notifierService’])
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'notifierAwsSnsService'; }

}