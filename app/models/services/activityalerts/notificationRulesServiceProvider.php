<?php
namespace Services\Activityalerts;

use Illuminate\Support\ServiceProvider;

/**
 * Register our notifier service with Laravel
 */
class NotificationRulesServiceProvider extends ServiceProvider
{
	/**
	 * Registers the service in the IoC Container
	 *
	 */
	public function register()
	{
		// Binds 'notifierService' to the result of the closure
		$this->app->bind('notificationRulesService', function($app)
		{
			return new NotificationRulesService();
		});
	}
}