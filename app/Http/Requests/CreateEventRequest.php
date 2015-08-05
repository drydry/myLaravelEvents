<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Http\JsonResponse;
use App\EventType;
use Auth;

class CreateEventRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $id = $this->route('id');

        if( !is_null($id) ){
            $eventType = EventType::find($id);
            return !is_null($eventType) && $eventType->owner == Auth::id();
        } else {
            return true;
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
        return new JsonResponse('You can\'t create this event because you are not the owner of this event type or it doesn\'t exist.', 403);
    }
}
