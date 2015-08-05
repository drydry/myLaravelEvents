<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;


class Booking extends Model
{

	// use soft delete;
	use SoftDeletes;

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
    	'note',
        'kicked'
    	];

    /**
 	* The attributes protected from multiple inserts.
 	*
 	* @var array
 	*/
	protected $guarded = array('id');

    /** RELATIONSHIPS **/
    public function user()
    {
        return $this->belongsTo('App\User', 'booker');
    }

    /** RELATIONSHIPS **/
    public function creator()
    {
        return $this->belongsTo('App\User', 'owner');
    }
    
    public function eventData()
    {
        return $this->belongsTo('App\Event', 'event');
    }


}
