<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

use App\Event;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $events = Event::all();
        return view('events.index', ['events' => $events, 'title' => 'All events']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $event = new Event;
        return view('events.create', ['event' => $event]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        // Event validation
        $this->validate($request, [
            'title' => 'required|min:1|max:255',
            'start_time' => 'required|date|after:tomorrow',
            'end_time' => 'required|date|after:start_time',
        ]);

        // Populates the event
        $event = new Event;
        $event->start_time = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $request->input('start_time'))));
        $event->end_time = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $request->input('end_time'))));
        $event->title = $request->input('title');
        $event->host = Auth::id();

        // Saves it
        $event->save();

        // Return all events view from controller
        return redirect()->action('EventsController@index');
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
        $event = Event::find($id)->first();
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
        $event = Event::find($id)->first();

        // Event validation
        $this->validate($request, [
            'title' => 'required|min:1|max:255',
            'start_time' => 'required|date|after:tomorrow',
            'end_time' => 'required|date|after:start_time',
        ]);

        // Populates the event
        $event->start_time = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $request->input('start_time'))));
        $event->end_time = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $request->input('end_time'))));
        $event->title = $request->input('title');

        // Saves it
        $event->save();

        // Return all events view from controller
        return redirect()->action('EventsController@index');
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

        return redirect()->action('EventsController@hosted');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function hosted()
    {
        $events = Event::myEvents()->get();

        return view('events.index', ['events' => $events, 'title' => 'Hosted events']);
    }

}
