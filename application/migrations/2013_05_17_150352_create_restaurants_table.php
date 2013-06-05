<?php

class Create_Restaurants_Table {    

	public function up()
    {
		Schema::create('restaurants', function($table) {
			$table->increments('id');
			$table->string('name');
			$table->text('description');
			$table->string('image');
			$table->string('address');
			$table->integer('telephone');
			$table->integer('status');
			$table->string('type');
			$table->integer('user_id');
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('restaurants');

    }

}