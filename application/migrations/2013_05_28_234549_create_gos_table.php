<?php

class Create_Gos_Table {    

	public function up()
    {
		Schema::create('gos', function($table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('club_id');
			$table->timestamps();
		});
    }    

	public function down()
    {
		Schema::drop('gos');
    }

}