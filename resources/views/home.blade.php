@extends('layouts.admin')

@section('content')

@if(\Auth::user()->id == 1)
<div>
Last 10 Logins:<br>
<table  class="table">
    <thead>
        <tr>
        <th scope="col">user created</th>
        <th scope="col">log created</th>
        <th scope="col">name</th>
        <th scope="col">email</th>
        <th scope="col">user agent</th>
        <th scope="col">ip</th>
        </tr>
    </thead>
    <tbody>
        @foreach(\App\Models\AuthLog::latest()->take(5)->get() as $log)
            <tr>
                <td>{{$log->user->created_at}}</td>
                <td>{{$log->created_at}}</td>
                <td>{{$log->user->name}}</td>
                <td>{{$log->user->email}}</td>
                <td>{{$log->user_agent}}</td>
                <td>{{$log->ip_address}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>
@endif
<div class="container">
    <div class="row dashrow">
        <a class="col-sm dashbox" href="#" data-featherlight="/characters/create">
            <div class="row">
                <div class="col-9">
                    <h2>Become a Hero</h2>
                    (create a character)
                    
                </div>
                <div class="col">
                    <img class="swordicon" width=80 height=80 src="/swords-emblem.svg">
                </div>
            </div>
        </a>
        
        <a class="col-sm dashbox" href="#" data-featherlight="/campaigns/create">
            <div class="row">
                <div class="col-9">
                    <h2>Build a World</h2>
                    (create a campaign)
                </div>
                <div class="col">
                    <img class="swordicon" width=80 height=80 src="/atlas.svg">
                </div>
            </div>
        </a>
    </div>
    
    <div class="row dashrow">
        <div class="col-sm">
            @if ($user->characters->first())
                <h2>Continue your Adventure...</h2>
                    @foreach ($user->characters as $character) 
                    <div>
                        <a href="#" style="color:black" class="editcharacter" data-featherlight="/characters/{{$character->id}}/edit"><i class="fas fa-edit"></i></a>
                        @if ($character->campaign)
                            <a href="/characters/{{$character->id}}" class="btn btn-success characterbutton"><h3>{{$character->name}}</h3> in {{$character->campaign->name}}</a>
                        @else
                            <a href="/characters/{{$character->id}}" class="btn btn-danger characterbutton"><h3>{{$character->name}}</h3> at the Tavern</a><a href="#" style="font-weight:bold; font-size: 8px" class="viewcampaigns btn btn-warning" data-featherlight="/publiccampaigns/{{$character->id}}">JOIN A<br>CAMPAIGN</a>
                        @endif
                            
                    </div>
                    @endforeach
            @endif
        </div>
        <div class="col-sm misadventurebox">
            @if ($user->campaigns->first())
                <h2>...Continue their MisAdventure</h2>
                    @foreach ($user->campaigns as $campaign)
                    <div> 
                        @if (null == $campaign->characters->first())
                            <a href="/campaigncharacters" class="btn btn-warning" style="font-weight:bold; font-size:8px">ADD<br>CHARACTERS</a>
                        @endif
                        @if ($campaign->areas->first())
                            <a href="/campaigns/{{$campaign->id}}" class="btn btn-success campaignbutton"><h3>{{$campaign->name}}</h3> 
                                @if(null !== $campaign->characters->first()) with @foreach ($campaign->characters as $character) {{$character->name}} @endforeach @endif</a>
                        @else
                            <a href="/areas" class="btn btn-danger campaignbutton"><h3>{{$campaign->name}}</h3> <small>NO AREA ASSIGNED! Click to set one to campaign</small></a>
                        @endif
                        <a href="#" style="color:black" class="editcampaign" data-featherlight="/campaigns/{{$campaign->id}}/edit"><i class="fas fa-edit"></i></a>
                    </div>
                    @endforeach
            @endif
        </div>
    </div>

</div>

@endsection

@section("scripts")
    @if (null !== session('invitecode'))
    <script>
        window.open('https://discord.gg/{{session('invitecode')}}');
        $.featherlight('<h2>Campaign Created!</h2><h5>A Popup with an Invite to your new Discord channel group should have come up, you will need to accept it now in order to become the admin for the group - if your browser is blocking the popup, click it <a target="_blank" href="https://discord.gg/{{session('invitecode')}}">here</a>');
    </script>
    @endif
@endsection
