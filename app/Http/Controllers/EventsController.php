<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

use App\Event;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Requests\DeleteEventRequest;

class EventsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        //1. SCOPES
        
        // Hosted events only
        if($request->hosted == 1){
            $events = Event::myEvents()->orderBy('created_at', 'desc');    
        } else {
        // All events (hosted+others)
            $events = Event::orderBy('created_at', 'desc');
        }

        //2. RELATIONSHIPS
        
        // include bookings
        if($request->bookings == 1){
            $events = $events->with('bookings'); 
        }
        // include creator details
        if($request->creator == 1){
            $events = $events->with('creator'); 
        }

        return response()->json($events->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(StoreEventRequest $request)
    {
        // Populates the event
        $event = new Event;
        $event->start_time = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $request->input('start_time'))));
        $event->end_time = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $request->input('end_time'))));
        $event->title = $request->input('title');
        $event->description = $request->input('description');
        $event->capacity = $request->input('capacity');
        // The host is the current connected user
        $event->host = Auth::id();

        // Saves it
        $event->save();

        // Return JSON
        return response()->json(array('success' => true));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $event = Event::find($id);
        return view('events.show', ['event' => $event]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $event = Event::find($id);
        return view('events.edit', ['event' => $event]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(UpdateEventRequest $Request, $id)
    {
        $event = Event::find($id);

        // Populates the event
        $event->start_time = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $request->input('start_time'))));
        $event->end_time = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $request->input('end_time'))));
        $event->title = $request->input('title');
        $event->description = $request->input('description');
        $event->capacity = $request->input('capacity');
        

        // Saves it
        $event->save();

        // Return current event in JSON
        return redirect()->action('EventsController@edit', ['event' => $event]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(DeleteEventRequest $request, $id)
    {
        // Event validation
        $event = Event::find($id);
        $event->delete();

        // Return JSON
        return response()->json(array('success' => true));
    }
}
