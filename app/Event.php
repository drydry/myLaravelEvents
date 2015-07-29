<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use Carbon\Carbon;

class Event extends Model {

	// use soft delete;
	use SoftDeletes;

	/**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'events';

    /**
    * The attributes that are fillable.
    *
    * @var array
    */
    protected $fillable = [
    	'title',
    	'host',
        'description',
        'capacity',
    	'start_time',
    	'end_time'
    	];

	/**
 	* The attributes protected from multiple inserts.
 	*
 	* @var array
 	*/
	protected $guarded = array('id');

    // Append 
    protected $appends = array('start_time_friendly', 'end_time_friendly');

    // Return the start time in friendly format.
    public function getStartTimeFriendlyAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->start_time)->format('m/d H:i:s');
    }

    // Return the end time in friendly format.
    public function getEndTimeFriendlyAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->end_time)->format('m/d H:i:s');
    }

	/** Relationships **/
	public function creator()
    {
        return $this->belongsTo('App\User', 'host');
    }

    public function bookings()
    {
        return $this->hasMany('App\Booking', 'event', 'id');
    }

    /**
     * Scope a query to only include events that belong to the current user.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMyEvents($query)
    {
        return $query->where('host', Auth::id());
    }

    /**
     * Scope a query to only include events in the future.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFutureOnly($query)
    {
        return $query->where('start_time', '>' ,  Carbon::now());   
    }

    /**
     * Scope a query to only include events that don't belong to the current user.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOtherEvents($query)
    {
        return $query->where('host', '<>', Auth::id());
    }
}
