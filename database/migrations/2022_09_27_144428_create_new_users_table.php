<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNewUsersTable extends Migration {

	public function up()
	{
		Schema::create('new_users', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('email');
			$table->string('password');
			$table->string('api_token');
			$table->integer('pin_code');
			$table->boolean('is_admin');
		});
	}

	public function down()
	{
		Schema::drop('new_users');
	}
}