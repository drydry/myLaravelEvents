<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

// use soft delete;
use SoftDeletes;

class Booking extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'bookings';

    /**
    * The attributes that are fillable.
    *
    * @var array
    */
    protected $fillable = [
    	'booker',
    	'note'
    	];

    /**
 	* The attributes protected from multiple inserts.
 	*
 	* @var array
 	*/
	protected $guarded = array('id');


}
