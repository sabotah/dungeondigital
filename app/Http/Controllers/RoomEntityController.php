<?php

namespace App\Http\Controllers;

use App\Models\RoomEntity;
use Illuminate\Http\Request;

class RoomEntityController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RoomEntity  $roomEntity
     * @return \Illuminate\Http\Response
     */
    public function show(RoomEntity $roomEntity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RoomEntity  $roomEntity
     * @return \Illuminate\Http\Response
     */
    public function edit(RoomEntity $roomEntity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RoomEntity  $roomEntity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RoomEntity $roomEntity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RoomEntity  $roomEntity
     * @return \Illuminate\Http\Response
     */
    public function destroy($roomentityid)
    {

        // why is it returning a collection instead of one entity???
        $roomentity = RoomEntity::find($roomentityid);
        $entityowner = $roomentity->entity->user_id;
        $authuser = \Auth::user();
        // echo $authuser->id.' - '.$entityowner;
        if ($authuser->id == $entityowner) {
            $result = $roomentity->delete();
            echo true;
        }
        else {
            echo false;
        }
    }
}
