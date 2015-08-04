<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreEventTypeRequest;
use App\Http\Controllers\Controller;
use App\EventType;
use Auth;

class EventTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $eventTypes = EventType::where('owner', Auth::id());

        return response()->json($eventTypes->get()); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('event-types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(StoreEventTypeRequest $request)
    {
        // Populates the event
        $eventType = new eventType;
        $eventType->title = $request->input('title');
        $eventType->description = $request->input('description');
        $eventType->capacity = $request->input('capacity');
        // The host is the current connected user
        $eventType->owner = Auth::id();

        // Saves it
        $eventType->save();

        // Return show form
        return redirect()->action('EventTypesController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
