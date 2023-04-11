<?php

namespace App\Http\Controllers;

use App\Models\Environment;
use App\Models\EnvironmentRow;
use App\Models\Area;

use Illuminate\Http\Request;

class EnvironmentController extends Controller
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
        $noname = false;

        if ($area->user_id == $authuser->id) {
            if (isset($request->name)) {
                $name = $request->name;
            }
            else {
                $noname = true;
                $name = 'noname';
            }

            $colour = $request->environment_colour;

            $rows = json_decode($request->environment_rows[0]);

            $environment = new Environment;

            $environment->colour = $colour;
            $environment->name = $name;
            $environment->area_id = $area->id;

            $environment->order = 0;

            $environment->save();

            $environmentareacount = Environment::where('area_id',$areaid)->count();

            $environment->order = $environmentareacount;

            if ($noname) {
                $environment->name = 'Environment'.$environmentareacount;
            }

            $environment->save();

            if (isset($environment->id)) {
                foreach ($rows as $row) {
                    if (isset($row->row)) {
                        $envrow = new EnvironmentRow;
                        $envrow->environment_id = $environment->id;
                        $envrow->row = $row->row;
                        $envrow->start_col = $row->fromcol;
                        $envrow->end_col = $row->tocol;
                        $envrow->save();

                        if ($envrow->end_col > $area->max_width) {
                            $area->max_width = $envrow->end_col+1;
                            $area->save();
                        }

                        if ($envrow->row > $area->max_height) {
                            $area->max_height = $envrow->row+1;
                            $area->save();
                        }
                    }
                }
            }
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Environment  $environment
     * @return \Illuminate\Http\Response
     */
    public function show(Environment $environment)
    {
        $response = array('success'=>false);
        $areaid = $environment->area_id;

        // $area = \App\Area::find($areaid);
        // $authuser = \Auth::user();

        // if ($area->user_id == $authuser->id) {

            $response['colour'] = $environment->colour;
            $response['order'] = $environment->order;
            $response['envrows'] = $environment->rows->all();
            $response['success'] = true;

        // }
        echo json_encode($response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Environment  $environment
     * @return \Illuminate\Http\Response
     */
    public function edit(Environment $environment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Environment  $environment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Environment $environment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Environment  $environment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Environment $environment)
    {
        $returnarray = array('success'=>false);
        $area = Area::find($environment->area_id);
        $environmentowner = $area->user_id;
        $authuser = \Auth::user();
        // echo $authuser->id.' - '.$entityowner;
        if ($authuser->id == $environmentowner) {

            if (!$environment->characters->isEmpty()) {
                $returnarray['error'] = 'character';
            }

            if (!$environment->campaigncreatures->isEmpty()) {
                $returnarray['error'] = 'creature';
            }

            if (!isset($returnarray['error'])) {
                foreach($environment->rows as $row) {
                    $row->delete();
                }

                if (\DB::table('character_environment')->where('environment_id',$environment->id)->get()) {
                    \DB::table('character_environment')->where('environment_id',$environment->id)->delete();
                }

                // @TODO: When we implement environments into the campaign viewm we need to check if Character or Creature is inside it
                // will need to also have an environmentid attached to entities... and will need to check that too
                $environment->delete();
                $returnarray['success'] = true;
            }
        }
        echo json_encode($returnarray);
    }
}
