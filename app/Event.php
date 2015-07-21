<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

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
    	'start_time',
    	'end_time'
    	];

	/**
 	* The attributes protected from multiple inserts.
 	*
 	* @var array
 	*/
	protected $guarded = array('id');

	/** Relationships **/
	public function creator()
    {
        return $this->belongsTo('App\User', 'host');
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
     * Scope a query to only include events that don't belong to the current user.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOtherEvents($query)
    {
        return $query->where('host', '<>', Auth::id());
    }

}
