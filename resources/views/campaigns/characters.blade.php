@extends('layouts.admin')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container">
    <div class="row">
        <div class="col">
           <h2>Campaigns:</h2>
           @foreach ($campaigns as $campaign)
           		<div class="campaignbuttons" campaignid="{{$campaign->id}}">
           			<button class="btn btn-primary">{{$campaign->name}}</button>
           		</div>
           @endforeach
        </div>
        <div class="col">
        	<h2 id="campaigncharacterstitle">Characters</h2>
           @foreach ($campaigns as $campaign)
           		<div class="row campaignsection campaignsection{{$campaign->id}}" campaignid="{{$campaign->id}}" style="display:none">
           			<div class="col charactersincampaign">
	           			<h3>Characters</h3>
	           			@foreach ($campaign->characters as $character)
			           		<div class="characterincampaign" characterid="{{$character->id}}">
			           			<button class="btn @if (isset($character->room_id) || isset($character->environment_id)) btn-success @else btn-info @endif">{{$character->name}}<span class="close removecharacter">x</span></button>
			           		</div>           			
			           	@endforeach
		           </div>
		           <div class="col creaturesincampaign" >
			           	<h3>Creatures</h3>
	           			@foreach ($campaign->campaigncreatures as $creature)
			           		<div class="creatureincampaign" campaigncreatureid="{{$creature->id}}">
			           			<button class="btn @if (isset($creature->room_id) || isset($creature->environment_id)) btn-success @else btn-info @endif">{{$creature->name}}<span class="close removecreature">x</span></button>
			           		</div>           			
			           	@endforeach
		           </div>
           		</div>
           @endforeach
           	<form id="findcharacters" style="display:none">
    			<label>Find Unassigned Characters under user to add to campaign: </label>
    			<input type="text" id="charactersearch" placeholder="Enter User Email">
    			<div id="usercharacters">
    		
    			</div>
    		</form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	// $('.campaignbuttons').click(function(){
	// 	$.ajax({
	// 		method: "POST",
	// 		url: "/areas/"+areaid+"/campaigns/"+campaignid,
	// 	})
	// 	.done(function(result) {
	// 		console.log(result);
	// 	})
	// })

	$('.creatureincampaign').click(function(){
		campaigncreatureid = $(this).attr('campaigncreatureid');
		$.featherlight('/campaigncreatures/'+campaigncreatureid+'/edit');
	})

	$('.campaignbuttons').click(function(){
		campaignid = $(this).attr('campaignid');
		campaignname = $(this).find('button').html();
		$('#campaigncharacterstitle').html(campaignname);
		$('.campaignsection').hide();
		$('.campaignsection [campaignid="'+campaignid+'"]').show();
		$('.campaignsection'+campaignid).show();
		$('#findcharacters').attr('campaignid',campaignid);
		$('#findcharacters').show();
		$('#usercharacters').html('');
	})

	$('.removecharacter').click(function(){
			campaignid = $('#findcharacters').attr('campaignid');
			characterid = $(this).parent().parent().attr('characterid');
			if (confirm('Are you sure you want to remove the Character from the Campaign? This will not delete the character, only remove it from the Campaign - You can add the character again if they havent been assigned to another Campaign')) {
				$.ajax({
					method: "POST",
					dataType: "json",
					url: "/campaigns/"+campaignid+"/characters/"+characterid,
				})
				.done(function(result) {
					console.log(result);
					if (result) {
						location.reload();
					}
				});		
			}
	});

	$('.removecreature').click(function(e){
			e.preventDefault();
			e.stopPropagation();
			campaigncreatureid = $(this).parent().parent().attr('campaigncreatureid');
			if (confirm('Are you sure you want to delete the CampaignCreature? You can create another instance of the creature, but this one will be removed - including its unique name and HP - from whevever it may be in the Campaign')) {
				$.ajax({
					method: "POST",
					dataType: "json",
					data: {_method:'DELETE',_token:'{{csrf_token()}}'},
					url: "/campaigncreatures/"+campaigncreatureid,
				})
				.done(function(result) {
					console.log(result);
					if (result) {
						location.reload();
					}
				});					
			}
	
	});


	$('#charactersearch').keypress(function(e){
		// e.preventDefault();
		// if enter is pressed
		thefield = this;
		campaignid = $('#findcharacters').attr('campaignid');
		if (e.which == 13) {
			e.preventDefault();
			email = $(thefield).val();
			console.log(email);
			$.ajax({
				method: "POST",
				dataType: "json",
				url: "/getcharactersfromemail",
				data: {email:email},
			})
			.done(function(result) {
				console.log(result);
				thelength = result.length - 1;

				if (!result[0]) {
					$('#usercharacters').html('No Characters for User! or Characters are already assigned to a campaign');
				} 
				else {
					characterlisthtml = '<p>Click Character name to Add them to the Campaign</p><ul class="foundcharacterslist">';
				}
				
				$.each(result,function(i,val){
					console.log(val.name+' i='+i+' length='+thelength);
					characterlisthtml += '<li class="foundcharacters" characterid="'+val.id+'" campaignid="'+campaignid+'"><div class="characterbutton btn btn-success">'+val.name+'</div></li>';
				})

				$('#usercharacters').html(characterlisthtml+'</ul>');
				// $('#usercharacters').append('</ul>');
				// we set the click listener here...
				

				$('.foundcharacters').click(function(){
					// console.log('wtf?');
					campaignid = $('#findcharacters').attr('campaignid');
					characterid = $(this).attr('characterid');
					console.log(campaignid+' '+characterid);
					$.ajax({
						method: "POST",
						dataType: "json",
						url: "/campaigns/"+campaignid+"/characters/"+characterid,
					})
					.done(function(result) {
						console.log(result);
						if (result) {
							location.reload();
						}
					})
				});
			})			
		}
	})

</script>

@endsection