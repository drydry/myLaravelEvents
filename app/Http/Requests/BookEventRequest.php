<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Http\JsonResponse;
use App\Event;
use App\Booking;
use Auth;

class BookEventRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Look for the event to book
        $event = Event::find($this->id);

        // Look for bookings for the sane event as the current user
        $bookings = Booking::where('event', $this->id)->where('booker', Auth::id())->get();

        return $event && count($bookings) == 0;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required,exists:events,unique:bookings,event',
            'booker' => 'required,exists:users,unique:bookings,booker',
        ];
    }

    public function forbiddenResponse()
    {
        return new JsonResponse('You can\'t book this event because it does not exist or you already booked it.', 403);
    }
}
