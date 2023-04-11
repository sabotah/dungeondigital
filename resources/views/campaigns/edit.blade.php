<form action="/campaigns/{{$campaign->id}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" aria-describedby="name" placeholder="{{$campaign->name}}" value="{{$campaign->name}}">
    </div>

    <div class="form-group">
        <label for="name">Game</label>
        <input type="text" class="form-control" id="game" name="game" aria-describedby="game" placeholder="{{$campaign->game}}" value="{{$campaign->game}}">
    </div>

    <div class="form-group">
        <label for="name">Ruleset</label>
        <input type="text" class="form-control" id="rulesversion" name="rulesversion" aria-describedby="rulesversion" placeholder="{{$campaign->rulesversion}}" value="{{$campaign->rulesversion}}">
    </div>
    @if (!isset($campaign->discordchannelid))
        <button id="creatediscordchannel">Create Discord Channel</button>
    @endif

    <div class="form-group row" id="publiclistedcontainer" @if (!isset($campaign->discordchannelid)) style="display:none" @endif>
        <div class="col-sm-5">List Campaign Publically?</div>
        <div class="col-sm-7">

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="publiclisted" name="publiclisted" @if ($campaign->publiclisted) checked @endif>
                    <label class="form-check-label" for="publiclisted">
                        <small>WARNING: This will allow users with available characters to be invited to your discord channel, if they agree to join your campaign</small>
                    </label>
                </div>
            
        </div>
    </div>

    <div class="form-group">
        <label for="name"> </label>

    </div>

    <div>
        <button class="btn btn-success" type="submit">Edit Campaign</button>
    </div>
    
</form>
<script>
    $('#creatediscordchannel').click(function(e){
        e.preventDefault();
        $.ajax({
            method: "POST",
            url: '/creatediscordchannel',
            data: {"campaignid":"{{$campaign->id}}","_token": "{{ csrf_token() }}" },
            // dataType: 'json',
        })
        .done(function(result) {
            console.log('here?');
            console.log(result);
            if (result) {
                $('#creatediscordchannel').replaceWith('<p style="color: green; font-weight: bold">Created Channel, Accept the Invite now to gain Admin rights to it! (the popup might be blocked by your browser, if so click <a href="https://discord.gg/'+result+'" target="_blank">Here</a>)</p>');
                $('#publiclistedcontainer').show();
                window.open('https://discord.gg/'+result);
            }
            // $('#creatediscordchannel').replaceWith('<a class="btn btn-success" href="https://discord.gg/'+result+'" target="_blank">Join Your New Discord Channel!</a>');
        })
    })
</script>