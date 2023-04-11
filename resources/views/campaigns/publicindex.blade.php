<div class="container" id="publiccampaignscontainer">
    <div class="row">
        <div class="col">
        	<h2>Public Campaigns</h2>
        	<p>(if you want to join a private one, give your DM your email address to add)</p>
			<ul>
					@foreach($campaigns as $campaign)
						<li class="btn btn-success pull-left publiccampaignbutton" campaignid="{{$campaign->id}}">Join {{$campaign->name}} <span class="badge badge-warning" title="Number of Current Players">{{$campaign->characters->count()}}</span> 
							@if ($campaign->game) <span class="badge badge-primary" title="Game type">{{$campaign->game}}</span> @endif
							@if ($campaign->rulesversion) <span class="badge badge-success" title="rulesetversion">{{$campaign->rulesversion}}</span> @endif
							@if (null == $campaign->areas->first()) <span class="badge badge-danger">NO AREAS</span> @endif
						</li>
					@endforeach
			</ul>
		</div>
	</div>
</div>
<script>
    $('.publiccampaignbutton').click(function(e){
        e.preventDefault();
        campaignid = $(this).attr('campaignid');

        $.ajax({
            method: "POST",
            url: '/joinpubliccampaign',
            data: {"campaignid":campaignid,"characterid":"{{$character->id}}","_token": "{{ csrf_token() }}" },
            // dataType: 'json',
        })
        .done(function(result) {
        	console.log(result);
            if (result) {
            	$('#publiccampaignscontainer').replaceWith('<p style="color: green; font-weight: bold">Joined Campaign! Accept the Invite now! You wont get it again! (the popup might be blocked by your browser, if so click <a href="https://discord.gg/'+result+'" target="_blank">Here</a>)</p>');
            }
                window.open('https://discord.gg/'+result);
        })
    })

</script>