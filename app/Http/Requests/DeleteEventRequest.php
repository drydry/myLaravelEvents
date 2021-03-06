<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Http\JsonResponse;
use App\Event;
use Auth;

class DeleteEventRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // We must validate that the connected user is the owner of the event to delete.
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
        return new JsonResponse('You can\'t delete this event because you are not the owner or this event doesn\'t exist.', 403);
    }
}
