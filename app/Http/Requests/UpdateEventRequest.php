<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Event;
use Auth;

class UpdateEventRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // We must validate that the connected user is the owner of the event to update.
        $eventId = $this->route('id');
        return Event::where('id', $eventId)->where('host', Auth::id())->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:1|max:255',
            'start_time' => 'required|date|after:tomorrow',
            'end_time' => 'required|date|after:start_time',
            'description' => 'max:255',
            'capacity' => 'integer',
        ];
    }
}
