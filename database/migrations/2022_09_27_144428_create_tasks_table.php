<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTasksTable extends Migration {

	public function up()
	{
		Schema::create('tasks', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('project_id')->unsigned();
			$table->string('name');
			$table->integer('user_id')->unsigned();
			$table->text('details');
		});
	}

	public function down()
	{
		Schema::drop('tasks');
	}
}