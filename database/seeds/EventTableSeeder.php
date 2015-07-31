<?php

use Illuminate\Database\Seeder;

class EventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->insert(
        	array(
        		array(
        			'host' => 2,
		            'title' => str_random(10),
		            'description' => str_random(25),
		            'capacity' => 0,
		            'start_time' => '2015-08-15 10:00:00',
		            'end_time' => '2015-08-15 13:00:00'),
        		array(
        			'host' => 3,
		            'title' => str_random(10),
		            'description' => str_random(25),
		            'capacity' => 0,
		            'start_time' => '2015-08-16 10:00:00',
		            'end_time' => '2015-08-16 13:00:00'),
        		array(
        			'host' => 4,
		            'title' => str_random(10),
		            'description' => str_random(25),
		            'capacity' => 1,
		            'start_time' => '2015-08-17 10:00:00',
		            'end_time' => '2015-08-17 13:00:00'),
        		array(
        			'host' => 5,
		            'title' => str_random(10),
		            'description' => str_random(25),
		            'capacity' => 1,
		            'start_time' => '2015-08-18 10:00:00',
		            'end_time' => '2015-08-18 13:00:00'),
        		array(
        			'host' => 6,
		            'title' => str_random(10),
		            'description' => str_random(25),
		            'capacity' => 4,
		            'start_time' => '2015-08-19 10:00:00',
		            'end_time' => '2015-08-19 13:00:00'),
        		array(
        			'host' => 7,
		            'title' => str_random(10),
		            'description' => str_random(25),
		            'capacity' => 4,
		            'start_time' => '2015-08-20 10:00:00',
		            'end_time' => '2015-08-20 13:00:00'),
        		)
       	);
    }
}
