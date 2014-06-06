<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('events', function($table)
		{
			$table->increments('id');
			$table->string('message_severity',64);
			$table->integer('event_publisher_id')->unsigned();
			$table->string('event_type_code','64');
			$table->tinyInteger('status')->default(0);
			$table->text('event_data');
			$table->timestamps();
			$table->foreign('event_publisher_id')
			->references('id')->on('event_publishers')
			->onDelete('cascade');
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
		Schema::drop('events');
	}

}
