<?php

namespace App\Http\Controllers;

use App\Models\CampaignArea;
use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignAreaController extends Controller
{


    public function toggleCampaignArea($areaid,$campaignid) {
        
        if (isset($areaid) && isset($campaignid)) {
            if (\Auth::user()->id == Campaign::find($campaignid)->user_id) {
                if (CampaignArea::where('area_id',$areaid)->where('campaign_id',$campaignid)->first()) {
                    // it exists, so lets remove it.
                    CampaignArea::where('area_id',$areaid)->where('campaign_id',$campaignid)->delete();
                }
                else {
                    // doesnt exist, so lets create
                    $campaignarea = new CampaignArea;
                    $campaignarea->area_id = $areaid;
                    $campaignarea->campaign_id = $campaignid;
                    $campaignarea->save();
                }
                // echo 'yay here '.$areaid.' | '.$campaignid;
            }
        }
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
     * @param  \App\CampaignArea  $campaignArea
     * @return \Illuminate\Http\Response
     */
    public function show(CampaignArea $campaignArea)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CampaignArea  $campaignArea
     * @return \Illuminate\Http\Response
     */
    public function edit(CampaignArea $campaignArea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CampaignArea  $campaignArea
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CampaignArea $campaignArea)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CampaignArea  $campaignArea
     * @return \Illuminate\Http\Response
     */
    public function destroy(CampaignArea $campaignArea)
    {
        //
    }
}
