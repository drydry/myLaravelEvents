<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Event;
use Auth;
use Illuminate\Http\JsonResponse;

class IndexBookingRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // We can return bookings only if the user is the event host.
        $event = Event::find($this->route('id'));
        return !is_null($event) && $event->host == Auth::id();
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
        return new JsonResponse('You can\'t view bookings on this event because you are not the owner or this event doesn\'t exist.', 403);
    }
}
