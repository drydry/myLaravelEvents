<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Booking;
use App\Event;
use Auth;
use Illuminate\Http\JsonResponse;

class KickUserBookingRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $return = false;

        $booking = Booking::find($this->id);

        // Wrong booking number given -> return false 
        if( !is_null($booking) ){
            // User not already kicked
            if( $booking->kicked == 0 ){
                $event = Event::find($booking->event);
                return $event->host == Auth::id();
            } else {
                return false;    
            }
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    public function forbiddenResponse()
    {
        return new JsonResponse('You can\'t kick this user because this event doesn\'t belong to you, doesn\'t exist or the user has already been kicked.', 403);
    }
}
