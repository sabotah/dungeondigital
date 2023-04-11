<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Models\RoomEntity;

use Illuminate\Http\Request;

class EntityController extends Controller
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
        $response = array('success'=>'false');
        // first we create the object, then we assign it to the room (and make sure the room belongs to the authuser)
        $height = $request->entity_height;
        $width = $request->entity_width;
        $name = $request->entity_name;
        $colour = $request->entity_colour;
        $radius = $request->entity_cornerradius;

        $entity = new Entity;

        $noname = false;
        if (!isset($name)) {
            $entity->name = 'noname';
            $noname = true;
        } else {
            $entity->name = $name;
        }

        $entity->colour = $colour;
        $entity->width = $width;
        $entity->height = $height;
        if (!isset($radius)) {
            $radius = 1;
        }
        $entity->cornerradius = $radius;
        $entity->user_id = \Auth::user()->id;

        $entity->save();

        $entityareacount = Entity::where('user_id',\Auth::user()->id)->count();

        if ($noname) {
            $entity->name = 'Object'.$entityareacount;
            $entity->save();
        }

        $entityid = $entity->id;

        $response['entityid'] = $entityid;
        $response['entityname'] = $entity->name;

        // if the entity saved correctly... lets set it to the room
        if ($entity->id) {
            $rowoffset = $request->entity_start_row;
            $coloffset = $request->entity_start_col;
            $roomid = $request->entity_room_id;
            // we wont be setting a custom name... just yet
            // or a custom colour
            // offset will be for top left coords in the area
            $roomentity = new RoomEntity;
            $roomentity->entity_id = $entity->id;
            $roomentity->room_id = $roomid;
            $roomentity->offset_row = $rowoffset;
            $roomentity->offset_col = $coloffset;
            $roomentity->save();


            $response['roomentityid'] = $roomentity->id;
            $response['success'] = 'true';
        }

        echo json_encode($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entity  $entity
     * @return \Illuminate\Http\Response
     */
    public function show(Entity $entity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entity  $entity
     * @return \Illuminate\Http\Response
     */
    public function edit(Entity $entity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entity  $entity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Entity $entity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity  $entity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entity $entity)
    {
        //
    }
}
