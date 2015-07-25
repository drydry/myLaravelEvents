<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreEventRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // No special authorization when saving an event.
        return true;
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
