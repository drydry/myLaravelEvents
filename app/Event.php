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

	/** RELATIONSHIPS **/
	public function creator()
    {
        return $this->belongsTo('App\User', 'host');
    }

    public function bookings()
    {
        return $this->hasMany('App\Booking', 'event', 'id');
    }

    public function eventType()
    {
        return $this->belongsTo('App\EventType', 'type');   
    }

    /** QUERY SCOPES **/

    /**
     * Scope a query to only include hosted events, based on the current connected user.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHosted($query)
    {
        return $query->where('host', Auth::id());
    }

    /**
     * Scope a query to only include upcoming events.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_time', '>' ,  Carbon::now());   
    }

    /**
     * Scope a query to only include events created by other users.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBelongsToOthers($query)
    {
        return $query->where('host', '<>', Auth::id());
    }

    /**
     * Scope a query to only include events that are not already booked by the current user.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotBooked($query)
    {
        return $query->where( function($query){
            // Event with booking and not booked by current user
            $query->whereRaw('events.capacity > (select count(*) from bookings where bookings.event = events.id)')
                ->whereRaw( Auth::id() . ' not in (select booker from bookings where events.id = bookings.event and bookings.deleted_at is null)');
            // Event with unlimited capacity
            })->orwhere(function($query){
                $query->where( 'events.capacity', '0')
                ->whereRaw( Auth::id() . ' not in (select booker from bookings where events.id = bookings.event and bookings.deleted_at is null)');
            });
    }

    /**
     * Scope a query to only include events where the current user participates and has not been kicked.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBooked($query){
        return $query->whereHas('bookings', function ($query) {
            $query->where('booker', Auth::id())->where('kicked', '0');
        });
    }
}
