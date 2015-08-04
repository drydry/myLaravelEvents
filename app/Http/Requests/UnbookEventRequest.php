<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Http\JsonResponse;
use App\Event;
use App\Booking;
use Auth;
use Carbon\Carbon;

class UnbookEventRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array();
    }

    /**
     * Override validator and adds specific error messages if the validation fails.
     *
     * @return $validator
     */
    public function getValidatorInstance() {
        $validator = parent::getValidatorInstance();

        $validator->after(function() use ($validator) {

            // Does the event exist?
            if( !$this->checkEventExists()){
                $validator->errors()->add('event.Exists', 'This event does not longer exist.');
            } else {

                // Does the booker is not the creator?
                if( !$this->checkEventNotBookedByCreator()){
                    $validator->errors()->add('event.BookedCreator', 'You can\'t unbook this event because since you are the owner.');   
                }

                // Does the event is not already finished/has begun?
                if( !$this->checkEventDateNotDue()){
                    $validator->errors()->add('event.DateDue', 'You can\'t unbook this event because it\'s already begun or is terminated.');   
                }
            }

        });

        return $validator;
    }

    /**
     * Checks if the event exists.
     *
     * @return boolean (true if control is OK, false otherwise)
     */
    private function checkEventExists(){
        $event = Event::find($this->id);

        return(!is_null($event));
    }

    /**
     * Checks if the event is not booked by its creator.
     *
     * @return boolean (true if control is OK, false otherwise)
     */
    private function checkEventNotBookedByCreator(){
        $event = Event::find($this->id);

        return($event->host != Auth::id());
    }

    /**
     * Checks if the event to book is not already finished.
     *
     * @return boolean (true if control is OK, false otherwise)
     */
    private function checkEventDateNotDue(){
        $event = Event::find($this->id);
        $now = Carbon::now();
         
        $startTime = Carbon::createFromFormat('Y-m-d H:i:s', $event->start_time);
        return $startTime->gt($now);
    }
}
