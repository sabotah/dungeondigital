<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Area;
use App\Models\Campaign;
use App\Models\Room;
use App\Models\Environment;
use App\Models\User;

use Illuminate\Http\Request;
use Carbon\Carbon;

class CharacterController extends Controller
{

    public function checkUpdates(Request $request, $characterid) {
        $character = Character::find($characterid);
        $currentroomid = $request->currentroom;
        $currentenvironmentid = $request->currentenvironment;
        $user = $character->user;
        if ($user->id == \Auth::user()->id) {
            $returninfo = array('success'=>false);
            $noroom = false;
            if (isset($character->lastchecked)) {
                // because there is a lastchecked set, it isnt the first init request


                $lastchecked = $character->lastchecked;
                // $returninfo['lastchecked'] = $lastchecked;

                // $returninfo['characterupdated'] = $character->updated_at;

                $differentroom = false;
                $noroom = false;

                if (!isset($character->room_id)) {
                    if (!isset($character->environment_id)) {
                        $noroom = true;
                    }
                }

                if (((($character->room && ($character->room->updated_at->gt($character->lastchecked))) ||
                ($character->environment && ($character->environment->updated_at->gt($character->lastchecked)))) ||
                $character->updated_at->gt($character->lastchecked) ||
                ((($request->currentcol != $character->current_col) || ($request->currentrow != $character->current_row)))
                 && $noroom == false)) {
                   
                    $returninfo['characterupdated'] = $character;
                    $returninfo['needsupdate'] = true;
                    // something has happened between now and before...
                    if ($currentroomid) {
                        $returninfo['currentroomid'] = $currentroomid;
                        $returninfo['roomid'] = $character->room_id;
                        if ($currentroomid != $character->room_id) {
                            $differentroom = true;
                            if ($character->room) {
                                $returninfo['room']['startrow'] = $character->room->start_row;
                                $returninfo['room']['startcol'] = $character->room->start_col;
                                $returninfo['room']['endrow'] = $character->room->end_row;
                                $returninfo['room']['endcol'] = $character->room->end_col;
                                $returninfo['room']['name'] = $character->room->name;
                            }
                            else if ($character->environment) {
                                $returninfo['environment']['name'] = $character->name;
                            }
                        }
                        //  because it is a new room, we need to get all room characters
                        if ($character->room) {
                            $returninfo['room']['startrow'] = $character->room->start_row;
                            $returninfo['room']['startcol'] = $character->room->start_col;
                            $returninfo['room']['endrow'] = $character->room->end_row;
                            $returninfo['room']['endcol'] = $character->room->end_col;
                            $returninfo['room']['name'] = $character->room->name;

                            //  because it is a new room, we need to get all room characters
                            foreach ($character->room->characters as $characterinroom) {
                                if ($characterinroom->campaign_id == $character->campaign_id) {
                                    $returninfo['updatedroomcharacters'][] = $characterinroom;
                                }
                            }
                            foreach ($character->room->campaigncreatures as $campaigncreature) {
                                if ($campaigncreature->campaign_id == $character->campaign_id) {
                                    $returninfo['updatedroomcreatures'][] = $campaigncreature;
                                }
                            }
                        }
                        else if ($character->environment) {
                            $returninfo['environment']['name'] = $character->name;
                            //  because it is a new room, we need to get all room characters
                            foreach ($character->environment->characters as $characterinenvironment) {
                                if ($characterinenvironment->campaign_id == $character->campaign_id) {
                                    $returninfo['updatedenvironmentcharacters'][] = $characterinenvironment;
                                }
                            }
                            foreach ($character->environment->campaigncreatures as $campaigncreature) {
                                if ($campaigncreature->campaign_id == $character->campaign_id) {
                                    $returninfo['updatedenvironmentcreatures'][] = $campaigncreature;
                                }
                            }
                        }
                    }
                    else if ($currentenvironmentid) {
                        // current
                        $returninfo['currentenvironmentid'] = $currentenvironmentid;
                        // what is set on char
                        $returninfo['environmentid'] = $character->environment_id;
                        $returninfo['roomid'] = $character->room_id;
                        if ($currentenvironmentid != $character->environment_id) {
                            // if we're no longer in the same environment...
                            // we could even be in a room!
                            $differentroom = true;
                        }

                        if ($character->room) {
                            $returninfo['room']['startrow'] = $character->room->start_row;
                            $returninfo['room']['startcol'] = $character->room->start_col;
                            $returninfo['room']['endrow'] = $character->room->end_row;
                            $returninfo['room']['endcol'] = $character->room->end_col;
                            $returninfo['room']['name'] = $character->room->name;

                            //  because it is a new room, we need to get all room characters
                            foreach ($character->room->characters as $characterinroom) {
                                if ($characterinroom->campaign_id == $character->campaign_id) {
                                    $returninfo['updatedroomcharacters'][] = $characterinroom;
                                }
                            }
                            foreach ($character->room->campaigncreatures as $campaigncreature) {
                                if ($campaigncreature->campaign_id == $character->campaign_id) {
                                    $returninfo['updatedroomcreatures'][] = $campaigncreature;
                                }
                            }
                        }
                        else if ($character->environment) {
                            $returninfo['environment']['name'] = $character->name;
                            //  because it is a new room, we need to get all room characters
                            foreach ($character->environment->characters as $characterinenvironment) {
                                if ($characterinenvironment->campaign_id == $character->campaign_id) {
                                    $returninfo['updatedenvironmentcharacters'][] = $characterinenvironment;
                                }
                            }
                            foreach ($character->environment->campaigncreatures as $campaigncreature) {
                                if ($campaigncreature->campaign_id == $character->campaign_id) {
                                    $returninfo['updatedenvironmentcreatures'][] = $campaigncreature;
                                }
                            }
                        }
                    }
                }
                // else if ($differentroom == false && $noroom == false) {
                //     // if the character is still in the same room... we'll see if people in the room have moved
                //     if (($request->pendingrequest == 'false' && !$character->requested_col)) {
                //         $returninfo['characterupdated'] = $character;

                //         if ($character->room) {
                //             foreach ($character->room->characters as $characterinroom) {
                //                 if ($characterinroom->campaign_id == $character->campaign_id) {
                //                     $returninfo['updatedroomcharacters'][] = $characterinroom;
                //                 }
                //             }

                //             foreach ($character->room->campaigncreatures as $campaigncreature) {
                //                 if ($campaigncreature->campaign_id == $character->campaign_id) {
                //                     $returninfo['updatedroomcreatures'][] = $campaigncreature;
                //                 }
                //             }
                //         }
                //         else if ($character->environment) {
                //             foreach ($character->environment->characters as $characterinenvironment) {
                //                 if ($characterinenvironment->campaign_id == $character->campaign_id) {
                //                     $returninfo['updatedenvironmentcharacters'][] = $characterinenvironment;
                //                 }
                //             }
                //             foreach ($character->environment->campaigncreatures as $campaigncreature) {
                //                 if ($campaigncreature->campaign_id == $character->campaign_id) {
                //                     $returninfo['updatedenvironmentcreatures'][] = $campaigncreature;
                //                 }
                //             }
                //         }
                //     }
                // }
                // $returninfo['init'] = false;
                // lets see if anything is more recent than the last checked...
            }
            $returninfo['noroom'] = $noroom;
            $returninfo['success'] = true;
            $returninfo['pending'] = $request->pendingrequest;

            if (isset($character->audioroom)) {
              // set it in the return and remove it from the campaign
              $returninfo['audioroom'] = $character->audioroom;
              $character->audioroom = null;
              $character->save();
            }
            echo json_encode($returninfo);
            $character->lastchecked = Carbon::now();
            $character->save();
        }
    }

    public function checkCharacterRequests($areaid,$campaignid) {
        // will have to make sure the area belongs to the admin user
        $area = Area::find($areaid);
        $campaign = Campaign::find($campaignid);
        $campaignadmin = $campaign->user;
        $authuser = \Auth::user();
        $returninfo = array('success'=>false);
        if (\Auth::user() && $campaignadmin->id == $authuser->id) {
            // we should touch the area to update modified timestamp whenever a request is made
            // but i'll also need a last checked for the area...
            foreach ($campaign->characters as $character) {
                // var_dump($character);
                if (isset($character->room_id)) {
                    if ($character->room->area->id == $area->id) {
                        if (isset($character->requested_col)) {
                            // there is a request! so lets send it back!
                            $returninfo['characterrequest'][] = $character;
                        }
                    }
                }

                if (isset($character->environment_id)) {
                    if ($character->environment->area->id == $area->id) {
                        if (isset($character->requested_col)) {
                            // there is a request! so lets send it back!
                            $returninfo['characterrequest'][] = $character;
                        }
                    }
                }
            }
        }
        $returninfo['success'] = true;
        echo json_encode($returninfo);
    }

    public function tableMap($characterid) {
        // if the area belongs to the user
        // $area = \App\Area::find(6);

        // $authuser = \Auth::user();

        $character = Character::find($characterid);

        // if ($character->user_id == $authuser->id) {
                return view('areas.test')->with('character',$character);

        // }

    }

    public function toggleCampaignCharacter($campaignid,$characterid,$joiningpublic = false) {
        if (isset($campaignid) && isset($characterid)) {
            $campaign = Campaign::find($campaignid);
            $character = Character::find($characterid);
            if ($campaign->user_id == \Auth::user()->id || $joiningpublic == true) {
                // if the campaign belongs to the authed user...
                if ($character->campaign_id) {
                    // has campaign id, so lets remove it from the character.
                    $character->campaign_id = null;
                    $character->room_id = null;
                    $character->current_col = null;
                    $character->current_row = null;
                    $character->save();
                    echo true;
                }
                else {
                    // doesnt have a campaign id... so lets set it
                    $character->campaign_id = $campaignid;
                    $character->save();
                    if ($joiningpublic == true) {
                        // if passing in a discordchannelid... it means the user is joining a public campaign
                        // and because its ajax we cant have it echoing... TODO: fix this
                        return true;
                    }
                    else {
                        echo true;
                    }
                }
            }
        }
    }

    public function getCharactersFromEmail(Request $request) {
        $email = $request->email;
        if ($email) {
            // this should be fine to be publically accessable, characters have no authentication, having read only access to a character pdf is fine publically too

            // hmm... should only list characters that arent already in a campaign
            $targetuser = User::where('email',$email)->first();
            $characters = $targetuser->characters()->whereNull('campaign_id')->get();
            echo json_encode($characters);
        }
    }

    public function viewCampaignCharacters() {
        $authuser = \Auth::user();
        if ($authuser->campaigns->first()) {
            $campaigns = $authuser->campaigns;
            return view('campaigns.characters')->with('campaigns',$campaigns);
        }
        else {
            return back()->with('error','You need to create a Campaign before assigning Characters');
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
        return view('characters.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // var_dump($request->all());
        // exit;
        // var_dump($request);
        if ($request->hasFile('charsheetfile')) {
            $path = $request->file('charsheetfile')->store('public');
        }
        $name = $request->name;
        $class = $request->class;
        $race = $request->race;
        $charsheet = $request->charsheet;

        $character = new Character;
        $character->name = $name;
        $character->class = $class;
        $character->race = $race;
        $character->charsheet = $charsheet;
        $character->user_id = \Auth::user()->id;

        if (isset($path)) {
            $character->charsheet = $path;
        }
        $character->save();

        return redirect('/home')->with('user',\Auth::user())->with('status','Character Created! Now give your DM your email address and you will be added to the Campaign!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function show(Character $character)
    {
        if (\Auth::user()->id == $character->user_id) {
            if ($character->room || $character->environment) {
                return view('characters.show')->with('character',$character);
            }
            else {
                return back()->with('error','Character does not belong to a Campaign! Give your email address to your DM. It could also be that the DM hasnt assigned you to a Room');
            }
        }
        else {
            echo 'Unauthorised. Try accessing your own character, not someone elses.';
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function edit($character)
    {
        $character = \App\Character::find($character);
        if ($character->user_id == \Auth::user()->id) {
            return view('characters.edit')->with('character',$character);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Character $character)
    {
        // if any of the actual character fields are updated when editing character..
        if (\Auth::user()->id == $character->user_id) {
            $editing = false;
            if ($request->name) {
                $character->name = $request->name;
                $editing = true;
            }

            if ($request->class) {
                $character->class = $request->class;
                $editing = true;
            }

            if ($request->race) {
                $character->race = $request->race;
                $editing = true;
            }

            if ($request->hasFile('charsheetfile')) {
                $path = $request->file('charsheetfile')->store('public');
                if ($path) {
                    $character->charsheet = $path;
                }
                $editing = true;
            }

            if ($editing == true) {
                $character->save();
                return redirect('/home')->with('user',\Auth::user())->with('status','Character Edited!');
            }
        }

        // change the modified of the originating room
        if ($character->room_id) {
            $originalroom = Room::find($character->room_id);
            $originalroom->touch();
        }

        if ($character->environment_id) {
            $originalenvironment = Environment::find($character->environment_id);
            $originalenvironment->touch();
        }

        if ($request->col && $request->row && ($request->roomid || $request->environmentid)) {
            $character->current_col = $request->col;
            $character->current_row = $request->row;

            if ($request->roomid) {
                $character->room_id = $request->roomid;
                $character->environment_id = null;
            }

            if ($request->environmentid) {
                $character->environment_id = $request->environmentid;
                $character->room_id = null;
            }
            // clear the player requested movement, because the dm has already moved the character
            $character->requested_col = null;
            $character->requested_row = null;
            $character->save();



            if ($request->roomid) {
                // we add the room to the visited rooms (character_room db table)
                $character->rooms()->detach($request->roomid);
                $character->rooms()->attach($request->roomid);

                Room::find($character->room_id)->area->touch();
                Room::find($character->room_id)->touch();
                $room = Room::find($character->room_id);

                foreach ($room->characters as $character) {
                    $character->touch();
                }
            }

            if ($request->environmentid) {
                // we add the environment to the visited environments (character_environment db table)
                $character->environments()->detach($request->environmentid);
                $character->environments()->attach($request->environmentid);

                Environment::find($character->environment_id)->area->touch();
                Environment::find($character->environment_id)->touch();
                $environment = Environment::find($character->environment_id);

                foreach ($environment->characters as $character) {
                    $character->touch();
                }
            }

            echo json_encode('true');
            return;
        }
        else if ($request->requested_col && $request->requested_row) {
            // this is when the character requests movement to a square
            $character->requested_col = $request->requested_col;
            $character->requested_row = $request->requested_row;
            $character->save();
            echo json_encode('true');

            if ($character->room_id) {
                Room::find($character->room_id)->area->touch();
                Room::find($character->room_id)->touch();
            }

            if ($character->environment_id) {
                Environment::find($character->environment_id)->area->touch();
                Environment::find($character->environment_id)->touch();
            }
            // touch area, so that admin knows that it needs to get all the requests for characters in the area
            return;
        }
    }

    public function unassign($characterid) {
        $returnarray = array('success'=>false);
        $character = Character::find($characterid);
        $campaign = Campaign::find($character->campaign_id);

        if ($campaign->user_id == \Auth::user()->id) {
            // remove room and campaigncreature coordinates from campaigncreature
            $originalroom = $character->room_id;
            $character->room_id = null;
            $character->environment_id = null;
            $character->current_col = null;
            $character->current_row = null;
            $character->requested_col = null;
            $character->requested_row = null;
            $character->save();
            $originalroom = Room::find($originalroom);
            if (isset($originalroom)) {
                $originalroom->touch();
            }

            // update the room so that it updates with the polling
            $returnarray['success'] = true;
        }

        echo json_encode($returnarray);
        return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function destroy(Character $character)
    {
        //
    }
}
