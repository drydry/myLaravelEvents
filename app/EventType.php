<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventType extends Model
{
    // use soft delete;
	use SoftDeletes;

	/**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'eventTypes';

    /**
    * The attributes that are fillable.
    *
    * @var array
    */
    protected $fillable = [
    	'creator',
    	'title',
        'description',
        'capacity'
    	];

    /**
 	* The attributes protected from multiple inserts.
 	*
 	* @var array
 	*/
	protected $guarded = array('id');

	/** RELATIONSHIPS **/
	public function creator()
    {
        return $this->belongsTo('App\User', 'owner');
    }
}
