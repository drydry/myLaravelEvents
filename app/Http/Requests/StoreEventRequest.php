<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Carbon\Carbon;
use App\Event;
use Auth;

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
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'description' => 'max:255',
            'capacity' => 'integer',
        ];
    }

    /**
     * Override validator and adds specific error messages if the validation fails.
     *
     * @return $validator
     */
    public function getValidatorInstance() {
        $validator = parent::getValidatorInstance();

        $validator->after(function() use ($validator) {

            // Event date times must be present
            if( $this->checkDateTimesPresent()){
                // Event in the future, at least 2 hours from now
                if( !$this->checkEventDateFuture()){
                    $validator->errors()->add('event.minDatetime', 'The event must be schedule from now + 2 hours in the future.');   
                }

                // Event duration is at least 10min
                if( !$this->checkEventDuration()){
                    $validator->errors()->add('event.duration', 'The duration must be at least 10min.');   
                }
                
                // Time slot available
                if( !$this->checkEventTimeSlotAvailable()){
                    $validator->errors()->add('event.timeSlot', 'You already have an event sharing those time frames.');
                }
            }                   
        });
        return $validator;
    }

    /**
     * Checks if the event date times are present.
     *
     * @return boolean (true if control is OK, false otherwise)
     */
    private function checkDateTimesPresent(){
        return $this->start_time != "" && $this->start_time != "";
    }

    /**
     * Checks if the event duration is at least 10min.
     *
     * @return boolean (true if control is OK, false otherwise)
     */
    private function checkEventDuration(){
        // Event date times
        $eventStartTime = Carbon::createFromFormat('m/d/Y h:i a', $this->start_time);
        $eventEndTime = Carbon::createFromFormat('m/d/Y h:i a', $this->end_time);
        // The difference must be at least 10minutes
        return $eventStartTime->diffInMinutes($eventEndTime) >= 10;
    }

    /**
     * Checks if the event time slot is available, not in concurrency with other events from the same host.
     *
     * @return boolean (true if control is OK, false otherwise)
     */
    private function checkEventTimeSlotAvailable(){
        // Event date times
        $newEventStartTime = Carbon::createFromFormat('m/d/Y h:i a', $this->start_time);
        $newEventEndTime = Carbon::createFromFormat('m/d/Y h:i a', $this->start_time);

        // Events already created for the current user
        $events = Event::where('host', Auth::id())->get();

        foreach ($events as $event) {
            $eventStartTime = Carbon::createFromFormat('Y-m-d H:i:s', $event->start_time);
            $eventEndTime = Carbon::createFromFormat('Y-m-d H:i:s', $event->end_time);

            // If the event to save start time OR end time is between start time/end time of an event that exists, error!
            if( ( $newEventStartTime->between($eventStartTime, $eventEndTime) || $newEventEndTime->between($eventStartTime, $eventEndTime) ) ){
                return false;
            } 
        }
        return true;
    }

    /**
     * Checks if the event times are in the future, at least 2 hours from now.
     *
     * @return boolean (true if control is OK, false otherwise)
     */
    private function checkEventDateFuture(){
        $startTime = Carbon::createFromFormat('m/d/Y h:i a', $this->start_time);
        $now = Carbon::now();

        return $now->diffInHours($startTime, false) >= 2;
    }


}
