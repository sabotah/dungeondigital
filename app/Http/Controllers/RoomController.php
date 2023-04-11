<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Area;
use Illuminate\Http\Request;

class RoomController extends Controller
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
            $name = $request->name;

            $startrow = $request->start_row;
            $startcol = $request->start_col;
            $endrow = $request->end_row;
            $endcol = $request->end_col;

            $room = new Room;

            $noname = false;
            if (!isset($name)) {
                $room->name = 'noname';
                $noname = true;
            } else {
                $room->name = $name;
            }

            $room->area_id = $areaid;
            $room->start_row = $startrow;
            $room->start_col = $startcol;
            $room->end_row = $endrow;
            $room->end_col = $endcol;

            if ($request->colour) {
                $room->colour = $request->colour;
            }

            $room->save();

            if (isset($request->description) && $request->description != '') {
                $room->description = $request->description;
                // this is where we also generate the audio file
                $audiostring = $room->createAudio();
                $room->audio = $audiostring;
                $room->save();
            }

            

            $roomareacount = Room::where('area_id',$areaid)->count();

            if ($noname) {
                $room->name = 'Room'.$roomareacount;
                $room->save();
            }

            if ($room->end_col > $area->max_width) {
                $area->max_width = $room->end_col+1;
                $area->save();
            }

            if ($room->end_row > $area->max_height) {
                $area->max_height = $room->end_row+1;
                $area->save();
            }

            $returnvalue = $room;
        }

        return json_encode($returnvalue);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        return json_encode($room);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        $authuser = \Auth::user();
        $returnvalue = 0;
        if ($room->area->user_id == $authuser->id) {
            $name = $request->name;

            if ($request->colour) {
                $room->colour = $request->colour;
            }

            if (isset($request->description) && $request->description != '') {
                $room->description = $request->description;
                // this is where we also generate the audio file
                $audiostring = $room->createAudio();
                $room->audio = $audiostring;
            }

            $roomareacount = Room::where('area_id',$room->area->id)->count();

            if (!isset($name)) {
                $room->name = 'Room'.$roomareacount;
            }
            else {
                $room->name = $name;
            }


            $room->save();

            $returnvalue = array('id'=>$room->id,'name'=>$room->name,'colour'=>$room->colour,'description'=>$room->description);
        }
        return json_encode($returnvalue);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        $returnarray = array('success'=>false);
        $roomowner = $room->area->user_id;
        $authuser = \Auth::user();
        if ($authuser->id == $roomowner) {
            if (!$room->characters->isEmpty()) {
                // var_dump($room->characters);
                $returnarray['error'] = 'character';
            }

            if (!$room->campaigncreatures->isEmpty()) {
                $returnarray['error'] = 'creature';
            }

            if (!$room->roomentities->isEmpty()) {
                $returnarray['error'] = 'entity';
            }

            // $characterrooms = \App\CharacterRoom::all();

            // foreach($characterrooms as $charroom) {
                // $charroom->delete();
            // }
            // var_dump($room->characters->pivot);
            // $characterrooms =
            if (!isset($returnarray['error'])) {
                if (\DB::table('character_room')->where('room_id',$room->id)->get()) {
                    \DB::table('character_room')->where('room_id',$room->id)->delete();
                }
            }

            if (!isset($returnarray['error'])) {
                foreach ($room->extensions as $extension) {
                    $extension->delete();
                }
                $room->delete();
                $returnarray['success'] = true;
            }



        }
        else {
            // echo false;
        }
        echo json_encode($returnarray);
    }

    public function listenToRoom(Request $request,$roomid) {
      $room = Room::find($roomid);
      if (!isset($request->description) || $request->description == $room->description) {
        return $room->audio;
      }
      else {
        $room->description = $request->description;
        // this is where we also generate the audio file
        $audiostring = $room->createAudio();
        $room->audio = $audiostring;
        $room->save();
        return $audiostring;
      }
    }
}
