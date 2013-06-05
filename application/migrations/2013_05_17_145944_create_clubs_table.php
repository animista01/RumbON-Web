<?php

class Create_Clubs_Table {    

	public function up()
    {
		Schema::create('clubs', function($table) {
			$table->increments('id');
			$table->string('name');
			$table->text('description');
			$table->string('image');
			$table->string('address');
			$table->integer('telephone');
			$table->string('horary');
			$table->string('type');
			$table->integer('user_id');
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('clubs');

    }

}