<?php

namespace App\Http\Controllers;

use App\Models\Door;
use App\Models\Area;

use Illuminate\Http\Request;

class DoorController extends Controller
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
        $returnvalue = 0;
        if ($area->user_id == $authuser->id) {
            $startrow = $request->door_start_row;
            $startcol = $request->door_start_col;
            $endrow = $request->door_end_row;
            $endcol = $request->door_end_col;

            if (isset($endrow) && isset($endcol)) {
                // if at least we have the end coords, we can set a door with default values
                $door = new Door;
                $door->area_id = $areaid;
                $door->end_row = $endrow;
                $door->end_col = $endcol;
                
                $door->start_row = $startrow;
                $door->start_col = $startcol;

                if ($request->locked == 'on')
                    $door->locked = true;


                if ($request->hidden == 'on')
                    $door->hidden = true;

                $door->difficulty = $request->difficulty;
                $door->placement = $request->placement;
                $door->save();
                $returnvalue = $door;
            }
        }  
        // return back();
        return json_encode($returnvalue);     
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Door  $door
     * @return \Illuminate\Http\Response
     */
    public function show(Door $door)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Door  $door
     * @return \Illuminate\Http\Response
     */
    public function edit(Door $door)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Door  $door
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Door $door)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Door  $door
     * @return \Illuminate\Http\Response
     */
    public function destroy(Door $door)
    {
        $doorowner = $door->area->user_id;
        $authuser = \Auth::user();
        if ($authuser->id == $doorowner) {
            $door->delete();
            echo true;
        }
        else {
            echo false;
        }
    }
}
