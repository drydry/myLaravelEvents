<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

use App\Event;
use App\Http\Requests\StoreEventRequest;

class EventsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        // Hosted events only
        if($request->hosted == 1){
            $events = Event::with('creator')->with('bookings')->myEvents()->orderBy('created_at', 'desc')->get();    
        } else {
        // All events (hosted+others)
            $events = Event::with('creator')->with('bookings')->orderBy('created_at', 'desc')->get();    
        }
        
        return response()->json($events);
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
    public function update(Request $request, $id)
    {
        $event = Event::find($id);

        // Event validation
        $this->validate($request, [
            'title' => 'required|min:1|max:255',
            'start_time' => 'required|date|after:tomorrow',
            'end_time' => 'required|date|after:start_time',
            'description' => 'max:255',
            'capacity' => 'integer',
        ]);

        // Populates the event
        $event->start_time = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $request->input('start_time'))));
        $event->end_time = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $request->input('end_time'))));
        $event->title = $request->input('title');
        $event->description = $request->input('description');
        $event->capacity = $request->input('capacity');
        

        // Saves it
        $event->save();

        // Return current event in JSON
        return response()->json($event);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        // Event validation
        $event = Event::find($id);
        $event->delete();

        // Return JSON
        return response()->json(array('success' => true));
    }
}
