<?php

namespace App\Http\Controllers;

use App\Models\Extension;
use App\Models\Area;
use App\Models\Room;
use Illuminate\Http\Request;

class ExtensionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $areaid = $request->area_id;

        $area = Area::find($areaid);
        $authuser = \Auth::user();

        if ($area->user_id == $authuser->id) {
            $room = Room::find($request->room_id);
            if ($room->area_id == $area->id) {
                $roomextension = new Extension;
                $roomextension->room_id = $room->id;
                $roomextension->start_row = $request->start_row;
                $roomextension->start_col = $request->start_col;
                $roomextension->end_row = $request->end_row;
                $roomextension->end_col = $request->end_col;  
                $roomextension->save();
                return 'true';
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Extension  $extension
     * @return \Illuminate\Http\Response
     */
    public function show(Extension $extension)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Extension  $extension
     * @return \Illuminate\Http\Response
     */
    public function edit(Extension $extension)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Extension  $extension
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Extension $extension)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Extension  $extension
     * @return \Illuminate\Http\Response
     */
    public function destroy(Extension $extension)
    {
        //
    }
}
