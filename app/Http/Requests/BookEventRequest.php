<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Http\JsonResponse;
use App\Event;
use App\Booking;
use Auth;
use Carbon\Carbon;

class BookEventRequest extends Request
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
                $validator->errors()->add('eventExists', 'This event does not longer exist.');
            } else {

                // Does the booker is not the creator?
                if( !$this->checkEventNotBookedByCreator()){
                    $validator->errors()->add('eventBookedCreator', 'You can\'t book this event because since you are the owner.');   
                }

                // Does the event is not already booked by this user?
                if( !$this->checkEventNotAlreadyBookedByUser()){
                    $validator->errors()->add('eventAlreadyBooked', 'You already have booked this event.');
                }

                // Does the event is not at the same time as other events already booked by this user?
                if( !$this->checkEventNotAtSameTime()){
                    $validator->errors()->add('eventSameTimeBooking', 'You can\'t book this event because one event you booked is at the same time.');   
                }

                // Does the event is not already finished/has begun?
                if( !$this->checkEventDateNotDue()){
                    $validator->errors()->add('eventDateDue', 'You can\'t book this event because it\'s already begun or is terminated.');   
                }

                // Does the event has not reached max capacity?
                if( !$this->checkEventNotFull()){
                    $validator->errors()->add('eventCapacityReached', 'You can\'t book this event because its maximum capacity is reached.');   
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
     * Checks if the event is not already booked by the current user.
     *
     * @return boolean (true if control is OK, false otherwise)
     */
    private function checkEventNotAlreadyBookedByUser(){
        return count(Booking::where('event', $this->id)->where('booker', Auth::id())->get()) == 0;
    }

    /**
     * Checks if the event to book is not at the same time as other booked events.
     *
     * @return boolean (true if control is OK, false otherwise)
     */
    private function checkEventNotAtSameTime(){
        $bookings = Booking::where('booker', Auth::id())->get();
        $eventToBook = Event::find($this->id);

        // Check all booked events
        foreach ($bookings as $booking) {
            $event = Event::find($booking->event);

            if(!is_null($event)){
                // Event to book time properties
                $eventToBookStartTime = Carbon::createFromFormat('Y-m-d H:i:s', $eventToBook->start_time);
                $eventToBookEndTime = Carbon::createFromFormat('Y-m-d H:i:s', $eventToBook->end_time);


                // Event booked time properties
                $eventStartTime = Carbon::createFromFormat('Y-m-d H:i:s', $event->start_time);
                $eventEndTime = Carbon::createFromFormat('Y-m-d H:i:s', $event->end_time);

                // If the event to book start time OR end time is between start time/end time of an event that is already booked, error!
                if( ( $eventToBookStartTime->between($eventStartTime, $eventEndTime) || $eventToBookEndTime->between($eventStartTime, $eventEndTime) ) ){
                    return false;
                } 
            }
        }

        return true;
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

    /**
     * Checks if the event to book is not full of capacity.
     *
     * @return boolean (true if control is OK, false otherwise)
     */
    private function checkEventNotFull(){
        $event = Event::find($this->id);

        $bookings = Booking::where('event', $this->id);
        // returns true if the number of bookings must be inferior to the event capacity OR if the event has not capacity defined. 
        return (count($bookings) < $event->capacity) || ($event->capacity == 0);
    }
}
