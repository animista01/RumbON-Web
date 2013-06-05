<?php

class Create_Promotions_Table {    

	public function up()
    {
		Schema::create('promotions', function($table) {
			$table->increments('id');
			$table->string('image');
			$table->text('body');
			$table->integer('club_id');
			$table->timestamps();
		});
    }    

	public function down()
    {
		Schema::drop('promotions');

    }

}