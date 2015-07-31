<?php

use Illuminate\Database\Seeder;

class BookingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bookings')->insert(
        	array(
        		array(
        			'event' => 35,
		            'booker' => 1
		        ),
        		array(
        			'event' => 36,
		            'booker' => 1
		        ),
        		array(
        			'event' => 37,
		            'booker' => 5
		        ),
        		array(
        			'event' => 37,
		            'booker' => 7
		        ),
        		array(
        			'event' => 37,
		            'booker' => 2
		        ),
        		array(
        			'event' => 37,
		            'booker' => 3
		        ),
        		array(
        			'event' => 38,
		            'booker' => 1
		        ),
        		array(
        			'event' => 38,
		            'booker' => 6
		        ),
        		array(
        			'event' => 38,
		            'booker' => 5
		        ),
        		array(
        			'event' => 38,
		            'booker' => 3
		        )
		    )
       	);
    }
}
