<?php

namespace App\Http\Controllers;

use App\Models\CampaignCreature;
use App\Models\Campaign;
use App\Models\Creature;
use App\Models\Room;
use App\Models\Environment;

use Illuminate\Http\Request;

class CampaignCreatureController extends Controller
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
    	$campaign = Campaign::find($request->campaign_id);
    	// if campaign is owned by authenticated user..
    	if (\Auth::user()->id == $campaign->user_id) {
    		// then lets check to see if the campaign already has a creature with the same name...
    		$numofcreatureincampaign = $campaign->campaigncreatures()->where('creature_id',$request->creature_id)->count();

    		$creature = Creature::find($request->creature_id);
    		$campaigncreature = new CampaignCreature;
    		$campaigncreature->creature_id = $request->creature_id;
    		$campaigncreature->campaign_id = $request->campaign_id;
    		$campaigncreature->area_id = $request->area_id;
    		if ($numofcreatureincampaign == 0) {
				$campaigncreature->name = $creature->name;
				$numofcreatureincampaign = $numofcreatureincampaign + 1;
    		}
    		else {
    			$numofcreatureincampaign = $numofcreatureincampaign + 1;
    			$campaigncreature->name = $creature->name.' '.$numofcreatureincampaign;
    		}
    		
    		$campaigncreature->count = $numofcreatureincampaign;
    		$campaigncreature->save();

    		echo json_encode(array('success'=>'true','id'=>$campaigncreature->id,'name'=>$campaigncreature->name));
    	}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CampaignCreature  $campaignCreature
     * @return \Illuminate\Http\Response
     */
    public function show(CampaignCreature $campaignCreature)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CampaignCreature  $campaignCreature
     * @return \Illuminate\Http\Response
     */
    public function edit($campaigncreatureid)
    {
        $campaignCreature = CampaignCreature::find($campaigncreatureid);
        $campaign = Campaign::find($campaignCreature->campaign_id);
        if ($campaign->user_id == \Auth::user()->id) {
            $creature = Creature::find($campaignCreature->creature_id);
            return view('campaigncreatures.edit')->with('campaigncreature',$campaignCreature)->with('creature',$creature);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CampaignCreature  $campaignCreature
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $campaigncreatureid)
    {
    	$campaignCreature = CampaignCreature::find($campaigncreatureid);
        $campaign = Campaign::find($campaignCreature->campaign_id);
        if ($campaign->user_id == \Auth::user()->id) {
            // it could be that we're just changing the fields, not the location
            // so lets check if the current hp is being passed in...
            if ($request->name) {
                // dont worry about upding location, because current hp is passed in
                $campaignCreature->name = $request->name;
                $campaignCreature->current_hp = $request->current_hp;
                $campaignCreature->save();
                return back();
            }
            else {
                // change the modified of the originating room
                if ($campaignCreature->room_id) {
                    $originalroom = Room::find($campaignCreature->room_id);
                    $originalroom->touch();
                }
                
                if ($campaignCreature->environment_id) {
                    $originalenvironment = Environment::find($campaignCreature->environment_id);
                    $originalenvironment->touch();
                }

                if ($request->col && $request->row && ($request->roomid || $request->environmentid)) {
                    $campaignCreature->current_col = $request->col;
                    $campaignCreature->current_row = $request->row;
                    if ($request->roomid) {
                        $campaignCreature->room_id = $request->roomid;
                        $campaignCreature->environment_id = null;
                    }

                    if ($request->environmentid) {
                        $campaignCreature->environment_id = $request->environmentid;
                        $campaignCreature->room_id = null;
                    }
                    
                    $campaignCreature->save();

                    if ($request->roomid) {
                        Room::find($campaignCreature->room_id)->area->touch();
                        Room::find($campaignCreature->room_id)->touch();
                        $room = Room::find($campaignCreature->room_id);

                        foreach ($room->characters as $character) {
                            $character->touch();
                        }
                    }

                    if ($request->environmentid) {
                        Environment::find($campaignCreature->environment_id)->area->touch();
                        Environment::find($campaignCreature->environment_id)->touch();
                        $environment = Environment::find($campaignCreature->environment_id);

                        foreach ($environment->characters as $character) {
                            $character->touch();
                        }
                    }
                }    

                echo json_encode('true');
                return;
            }
        }
    }

    public function unassign($campaigncreatureid) {
        $returnarray = array('success'=>false);
        $campaigncreature = CampaignCreature::find($campaigncreatureid);
        $campaign = Campaign::find($campaigncreature->campaign_id);

        if ($campaign->user_id == \Auth::user()->id) {
            // remove room and campaigncreature coordinates from campaigncreature
            $originalroom = $campaigncreature->room_id;
            $campaigncreature->room_id = null;
            $campaigncreature->area_id = null;
            $campaigncreature->current_col = null;
            $campaigncreature->current_row = null;
            $campaigncreature->save();
            $originalroom = Room::find($originalroom);
            $originalroom->touch();
            // update the room so that it updates with the polling
            $returnarray['success'] = true;
        }

        echo json_encode($returnarray);
        return;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CampaignCreature  $campaignCreature
     * @return \Illuminate\Http\Response
     */
    public function destroy($campaigncreatureid)
    {   
        $campaignCreature = CampaignCreature::find($campaigncreatureid);
        $campaign = Campaign::find($campaignCreature->campaign_id);
        if ($campaign->user_id == \Auth::user()->id) {
            $campaignCreature->delete();
            echo true;
        }
    }
}
