<?php

class Create_Users_Table {    

	public function up()
    {
		Schema::create('users', function($table) {
			$table->increments('id');
			$table->string('name');
			$table->integer('telephone');
			$table->string('email');
			$table->integer('type');
			$table->string('image')->nullable();
			$table->string('api_key');
			$table->string('password');
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('users');

    }

}
