<?php

namespace App\Http\Controllers;

use App\Models\Creature;
use Illuminate\Http\Request;

class CreatureController extends Controller
{

    public function searchCreatures(Request $request) {
        $creatures = Creature::where('name','like','%'.$request->name.'%')->get();
        echo json_encode($creatures);
    }

    public function import(Request $request){
        // foreach ($request->monsterdata as $creature) {
        //     // echo $creature['name'];
        //     $newcreature = new \App\Creature;
        //     // $data = $creature->only($newcreature->getFillable());
        //     $data = array_only($creature, $newcreature->getFillable());
        //     $newcreature->fill($data)->save();

        //     if (isset($creature['actions'])) {
        //         $newaction = new \App\Action;
        //         // $data = $creature->actions->only($newaction->getFillable());
        //         foreach($creature['actions'] as $creatureaction) {
        //             $data = array_only($creatureaction, $newaction->getFillable());
        //             $newaction->fill($data)->save();
        //             $newcreature->actions()->attach($newaction->id);
        //         }
        //     }

        //     if (isset($creature['legendary_actions'])) {
        //         $newlegendaryaction = new \App\Action;

        //         foreach ($creature['legendary_actions'] as $creaturelegendaryaction) {
        //             $data = array_only($creaturelegendaryaction, $newlegendaryaction->getFillable());
        //             // $data = $creature->actions->only($newlegendaryaction->getFillable());
        //             $newlegendaryaction->fill($data);
        //             $newlegendaryaction->legendary = true;
        //             $newlegendaryaction->save();
        //             $newcreature->actions()->attach($newlegendaryaction->id);
        //         }
        //     }

        //     if (isset($creature['special_abilities'])) {
        //         $newability = new \App\Ability;

        //         foreach ($creature['special_abilities'] as $creatureabilities) {
        //             $data = array_only($creatureabilities, $newability->getFillable());
        //             // $data = $creature->special_abilities->only($newability->getFillable());
        //             $newability->fill($data)->save();
        //             $newcreature->abilities()->attach($newability->id);
        //         }
        //     }
        //     // all data should now be in database.
        // }
    }
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
     * @param  \App\Creature  $creature
     * @return \Illuminate\Http\Response
     */
    public function show(Creature $creature)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Creature  $creature
     * @return \Illuminate\Http\Response
     */
    public function edit(Creature $creature)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Creature  $creature
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Creature $creature)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Creature  $creature
     * @return \Illuminate\Http\Response
     */
    public function destroy(Creature $creature)
    {
        //
    }
}
