<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Area;
use App\Models\Room;
use App\Models\Character;

use Illuminate\Http\Request;

class CampaignController extends Controller
{

    public function showCampaignArea($campaign,$area)
    {
        $campaign = Campaign::find($campaign);
        $area = Area::find($area);
        $user = \Auth::user();
        if ($campaign->user_id == $user->id) {
            return view('campaigns.show')->with('campaign',$campaign)->with('currentarea',$area);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // echo 'ahhh what?';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('campaigns.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->name;
        $game = $request->game;
        $rulesversion = $request->rulesversion;

        $user = \Auth::user();

        $campaign = new Campaign;
        $campaign->name = $name;
        $campaign->game = $game;
        $campaign->rulesversion = $rulesversion;
        $campaign->user_id = $user->id;
        $campaign->save();

        $invitecode = null;

        if ($request->creatediscord == "on") {
            // echo 'herE?';
            if ($invitecode = app('App\Http\Controllers\HomeController')->passCampaignToNode($campaign->id)) {
                return redirect('/home')->with('invitecode',$invitecode);
            }
        }
        else {
            return redirect('/home')->with('user',\Auth::user());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaign)
    {
        $campaign = Campaign::find($campaign->id);
        $user = \Auth::user();
        if ($campaign->user_id == $user->id) {
            return view('campaigns.show')->with('campaign',$campaign);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function edit($campaign)
    {
        $campaign = Campaign::find($campaign);
        if ($campaign->user_id == \Auth::user()->id) {
            return view('campaigns.edit')->with('campaign',$campaign);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Campaign $campaign)
    {
        $user = \Auth::user();
        if ($user->id == $campaign->user_id) {
            $name = $request->name;
            $game = $request->game;
            $rulesversion = $request->rulesversion;


            $user = \Auth::user();

            // $campaign = new \App\Campaign;
            $campaign->name = $name;
            $campaign->game = $game;
            $campaign->rulesversion = $rulesversion;
            $campaign->user_id = $user->id;

            if ($request->publiclisted == 'on') {
                $campaign->publiclisted = true;
            }
            else {
                $campaign->publiclisted = false;
            }

            $campaign->save();
        }
            // echo json_encode('true');
            return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign $campaign)
    {
        //
    }

    public function publicIndex($characterid) {
        $publiccampaigns = Campaign::where('publiclisted',true)->get();
        $character = Character::find($characterid);
        if ($character->user_id == \Auth::user()->id && null == $character->campaign) {
            return view('campaigns.publicindex')->with('campaigns',$publiccampaigns)->with('character',$character);
        }
    }

    public function joinPublicCampaign(Request $request) {
        if ($request->campaignid && $request->characterid) {
            $campaign = Campaign::find($request->campaignid);
            $character = Character::find($request->characterid);
            if ($campaign->publiclisted == true && null == $character->campaign) {
                $code = app('App\Http\Controllers\HomeController')->passChannelIdToNode($campaign->discordchannelid);
                if (isset($code)) {
                    $result = app('App\Http\Controllers\CharacterController')->toggleCampaignCharacter($campaign->id,$character->id,true);
                    echo $code;
                }
            }
        }
    }

    public function setAudioRoom($campaignid,$roomid) {
      $campaign = Campaign::find($campaignid);
      $room = Room::find($roomid);
      if ($campaign->user_id == \Auth::user()->id) {
        // foreach characters in campaign, set audioroom as room
        foreach ($campaign->characters as $character) {
          $character->audioroom = $roomid;
          $character->save();
        }
      }
    }
}
