<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('projects', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('new_users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('tasks', function(Blueprint $table) {
			$table->foreign('project_id')->references('id')->on('projects')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('tasks', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('new_users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});

		Schema::table('submitted_tasks', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('new_users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
	}

	public function down()
	{
		Schema::table('projects', function(Blueprint $table) {
			$table->dropForeign('projects_user_id_foreign');
		});
		Schema::table('tasks', function(Blueprint $table) {
			$table->dropForeign('tasks_project_id_foreign');
		});
		Schema::table('tasks', function(Blueprint $table) {
			$table->dropForeign('tasks_user_id_foreign');
		});
	}
}