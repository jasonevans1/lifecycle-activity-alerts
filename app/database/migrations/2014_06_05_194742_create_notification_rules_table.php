<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationRulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('notification_rules', function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->text('conditions');
			$table->text('actions');
			$table->tinyInteger('status')->default(1);
			$table->timestamps();
		});
		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::drop('notification_rules');
	}

}
