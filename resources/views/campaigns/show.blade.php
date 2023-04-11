@extends('layouts.admin')

@section('content')
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<?php

		if (isset($currentarea)) {
			$area = $currentarea;
		}
		else {
			$area = $campaign->areas->first();
			// $area = \App\Models\Area::find($campaignarea->area_id);
		}

	?>


	@if ($area->doors->first())
		<ul class="doorlist hiddenlist">
			<li><h3>Doors in Area:</h3></li>
			@foreach ($area->doors as $door)
				<li class="doorinlist" name="door_{{$door->id}}" doorid="{{$door->id}}" startrow="{{$door->start_row}}" startcol="{{$door->start_col}}" endrow="{{$door->end_row}}" endcol="{{$door->end_col}}" locked="{{$door->locked}}" ishidden="{{$door->hidden}}" difficulty="@isset($door->difficulty) {{$door->difficulty}} @else 0 @endisset" placement="{{$door->placement}}"><button class="btn btn-primary" >Door{{$door->id}} <span class="deletedoor" doorid="{{$door->id}}"><i class="fas fa-times"></i></span></button></a></li>
			@endforeach
		</ul>
	@endif

	@if ($area->rooms->first())
		<ul class="objectlist hiddenlist">
			<li><h3>Objects in Area: </h3></li>
			@foreach ($area->rooms as $room)
				@foreach ($room->roomentities as $roomentity)
					<li class="objectinlist" name="{{$roomentity->entity->name}}" roomentityid="{{$roomentity->id}}" startrow="{{$roomentity->offset_row}}" startcol="{{$roomentity->offset_col}}" endrow="{{$roomentity->getEndRow()}}" endcol="{{$roomentity->getEndCol()}}" colour="{{$roomentity->entity->colour}}" radius="{{$roomentity->entity->cornerradius}}"><button class="btn btn-primary" >{{$roomentity->entity->name}}_{{$roomentity->id}} ({{$room->name}}) <span class="deleteroomentity" roomid="{{$room->id}}" roomentityid="{{$roomentity->id}}"><i class="fas fa-times"></i></span></button></a></li>
				@endforeach
			@endforeach
		</ul>
	@endif


	<div class="row initiativepanel">
		<div class="col mainpanel" id="initiativepanel">

			<ul class="arealist">
			<li><h5 id="campaigntitle">{{$campaign->name}} <a href="#" style="color:black" class="editcampaign" data-featherlight="/campaigns/{{$campaign->id}}/edit"><i class="fas fa-edit"></i></a></h5>
				<div class="infobox row" style="display: none">
					<div class="col">
				- Click CampaignCharacters at the top and search a user's email to add unassigned characters<br>
				- Click on a Character once, then click on a Room to assign<br>
				- You can also drag Characters to different rooms within the map<br>
				- Characters/Creatures can be stacked ontop of each other<br>
				- Drag the map itself to position it
				- Scroll (slowly!) over the map to Zoom!<br>
				- Click Plus to add Creatures!<br>
				- If a Character silhouette appears, it means a player wants to move there, click it to Approve!<br>
				- Click the X on a character/creature to unassign them<br>
				- Click on another area to Assign/Re-Assign Actors to new area!<br>
					</div>
						<button class="btn btn-info">Ok, I get it.</button>
				</div>
			</li>
			@foreach ($campaign->areas->sortBy('id') as $listarea)
				<li><a href="/campaigns/{{$campaign->id}}/areas/{{$listarea->id}}" class="btn @if($listarea->id == $area->id) btn-success @else btn-primary @endif">{{$listarea->name}}</a></li>
			@endforeach
			<li> - </li>
			<li><button class="btn btn-warning" id="togglegridlines">Toggle Gridlines</button></li>
			<li><button class="btn btn-danger" id="exportarea">Export to PNG</button></li>
			</ul>
		</div>
	</div>
	<div id="toggleactoractionpanel"><button class="btn btn-danger">Hide Panel</button></div>
	<div id="togglehelp"><button class="btn btn-danger">Show Help</button></div>
    <div class="row mainpanels">
    	<div class="col-md-2 col-sm-5 mainpanel list-group" id="actoractionpanel">

    		ActorAction Panel
	    		<ul class="roomsInArea list-group roomlist">
	    				<li class="list-group-item" id="unassignedcharacters">
	    					<label>Unassigned Actors <span id="showaddcreature"><i class="fas fa-plus"></i></span>
								<input type="text" class="form-text" placeholder="Creature Name" id="addcreaturetext" style="display:none">
	    					</label>
	    					<div id="addcreaturelist" style="display:none"></div>
    						 <ul class="charactersInRoom list-group">
							@foreach ($campaign->characters as $character)
								@if (!$character->room_id && !$character->environment_id)
									<button class="btn menucharacter btn-success" characterid="{{$character->id}}" currentroom="0" currentenvironment="0"><label characterid="{{$character->id}}">{{$character->name}}</label></button>
								@endif
							@endforeach

							@foreach ($campaign->campaigncreatures as $campaigncreature)
								@if (!$campaigncreature->room_id && !$campaigncreature->environment_id)
									<button class="btn menucharacter btn-danger" currentroom="0" currentenvironment="0" campaigncreatureid="{{$campaigncreature->id}}" creatureid="{{$campaigncreature->creature_id}}"><label campaigncreatureid="{{$campaigncreature->id}}" creatureid="{{$campaigncreature->creature_id}}">{{$campaigncreature->name}}</label> <a href="#" class="editcampaigncreature" data-featherlight="/campaigncreatures/{{$campaigncreature->id}}/edit"><i class="fas fa-edit"></i></a> </button>
								@endif
							@endforeach


							</ul>
	    				</li>


					@foreach ($area->environments as $environment)
	    				<li class="list-group-item menuroom roominlist environmentinlist" name="{{$environment->name}}" environmentid="{{$environment->id}}">
	    					<label>{{$environment->name}}</label>
    						<ul class="charactersInRoom charactersInEnvironment list-group">
								@foreach ($campaign->characters as $character)
									{{-- if the character has an environmnet id but doesnt have a roomid set.. --}}
									@if (isset($character->environment_id) && !isset($character->room_id))
										@if ($environment->id == $character->environment_id)
											<button class="btn btn-success menucharacter characterinenvironment characterinroom" col="@isset($character->current_col){{$character->current_col}}@endisset" row="@isset($character->current_row){{$character->current_row}}@endisset" requestedrow="@isset($character->requested_row){{$character->requested_row}}@endisset" requestedcol="@isset($character->requested_col){{$character->requested_col}}@endisset" characterid="{{$character->id}}" currentenvironment="{{$environment->id}}"><label characterid="{{$character->id}}">{{$character->name}}</label><span class="close unassigncharacter">x</span></button>
										@endif
									@endif
								@endforeach

								@foreach ($campaign->campaigncreatures as $campaigncreature)
									@if (isset($campaigncreature->environment_id) && !isset($campaigncreature->room_id))
										@if ($environment->id == $campaigncreature->environment_id)
											<button class="btn btn-danger menucharacter characterinenvironment creatureinenvironment characterinroom creatureinroom" col="@isset($campaigncreature->current_col){{$campaigncreature->current_col}}@endisset" row="@isset($campaigncreature->current_row){{$campaigncreature->current_row}}@endisset" campaigncreatureid="{{$campaigncreature->id}}" currentenvironment="{{$environment->id}}"><label campaigncreatureid="{{$campaigncreature->id}}">{{$campaigncreature->name}}</label> <a href="#" class="editcampaigncreature" data-featherlight="/campaigncreatures/{{$campaigncreature->id}}/edit"><i class="fas fa-edit"></i></a><span class="close unassigncreature">x</span></button>
										@endif
									@endif
								@endforeach
							</ul>
	    				</li>
					@endforeach



	    			@foreach ($area->rooms as $room)
	    				<li class="list-group-item menuroom roominlist" name="{{$room->name}}" roomid="{{$room->id}}" startrow="{{$room->start_row}}" startcol="{{$room->start_col}}" endrow="{{$room->end_row}}" endcol="{{$room->end_col}}" colour="{{$room->colour}}">
	    					<label>{{$room->name}}</label> @if ($room->description) <span class="speakroom" roomid="{{$room->id}}"><i class="fas fa-volume-up" style="cursor: pointer"></i></span> @endif
	    						 <ul class="charactersInRoom list-group">
								@foreach ($campaign->characters as $character)
									@if ($room->id == $character->room_id)
										<button class="btn btn-success menucharacter characterinroom" col="@isset($character->current_col){{$character->current_col}}@endisset" row="@isset($character->current_row){{$character->current_row}}@endisset" requestedrow="@isset($character->requested_row){{$character->requested_row}}@endisset" requestedcol="@isset($character->requested_col){{$character->requested_col}}@endisset" characterid="{{$character->id}}" currentroom="{{$room->id}}"><label characterid="{{$character->id}}">{{$character->name}}</label><span class="close unassigncharacter">x</span></button>
									@endif
								@endforeach

								@foreach ($campaign->campaigncreatures as $campaigncreature)
									@if ($room->id == $campaigncreature->room_id)
										<button class="btn btn-danger menucharacter characterinroom creatureinroom" col="@isset($campaigncreature->current_col){{$campaigncreature->current_col}}@endisset" row="@isset($campaigncreature->current_row){{$campaigncreature->current_row}}@endisset" campaigncreatureid="{{$campaigncreature->id}}" currentroom="{{$room->id}}"><label campaigncreatureid="{{$campaigncreature->id}}">{{$campaigncreature->name}}</label> <a href="#" class="editcampaigncreature" data-featherlight="/campaigncreatures/{{$campaigncreature->id}}/edit"><i class="fas fa-edit"></i></a><span class="close unassigncreature">x</span></button>
									@endif
								@endforeach
								</ul>
							@if ($room->extensions->first())
								<ul class="roomextensionlist clearfix minorpanel hiddenpanel" style="display: none">
									@foreach ($room->extensions as $roomext)
										<li class="roomextensioninlist" name="{{$room->name}}" roomid="{{$room->id}}" startrow="{{$roomext->start_row}}" startcol="{{$roomext->start_col}}" endrow="{{$roomext->end_row}}" endcol="{{$roomext->end_col}}"></li>
									@endforeach
								</ul>
							@endif
	    				</li>

	    			@endforeach
	    		</ul>
    	</div>
        <div class="col mainpanel" id="mappanel">
        	<span id="currentroom"></span>
        </div>



    </div>
    {{-- <div class="row floatingmapcontainer"> --}}
		<div id="areagrid" areaid="{{$area->id}}"></div>
    {{-- </div> --}}
@endsection

@section("scripts")
	<script src="/js/mousewheel/jquery.mousewheel.js"></script>
	<script src="/js/html2canvas.js"></script>
	<script>
			$(document).ready(function () {

				$('.speakroom').click(function(e){
					e.stopPropagation();
					console.log('here?');
					roomid = $(this).attr('roomid');
					$.ajax({
						method: "POST",
						url: "/rooms/"+roomid+"/listen",
						data: {"description":''},
					})
					.done(function(result) {
						if (result) {
							// ok we have the audio file, now we just need to set audioroom for campaign
							$.ajax({
								method: "GET",
								url: "/campaigns/"+{{$campaign->id}}+"/setaudioroom/"+roomid,
							})
							.done(function(theresult) {
								console.log(theresult)
								var audioElement = document.createElement('audio');
						    audioElement.setAttribute('src', '/storage/audio/'+result);
								audioElement.play();
							});


							// and we also need to play it on the player screens too...
						}
					})
				})

				$('.editcampaigncreature').click(function(e){
					e.stopPropagation();
				})

				$('.infobox button').click(function(){
					$('.infobox').fadeOut();
					$('#togglehelp button').html('Show Help')
					helphidden = true;
				})

				var timeoutID = null;

				$('#addcreaturetext').hide();

				$.ajaxSetup({
				    headers: {
				        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				    }
				});

				$('.unassigncreature').click(function(e){
					e.stopPropagation();
					campaigncreatureid = $(this).parent().attr('campaigncreatureid');
					name = $(this).parent().html();
					//console.log(campaigncreatureid);
					$.ajax({
		    			method: "GET",
		    			url: '/campaigncreatures/'+campaigncreatureid+'/unassign',
		    			dataType: 'json',
		    		})
	    			.done(function(result) {
	    				if (result.success) {
	    					$('.characterinroom[campaigncreatureid="'+campaigncreatureid+'"]').remove();

	    					$('#unassignedcharacters .charactersInRoom').append('<button class="btn menucharacter btn-danger" currentroom="0" campaigncreatureid="'+campaigncreatureid+'"><label campaigncreatureid="'+campaigncreatureid+'">'+name+'</label></button>');

	    					$('.menucharacter[campaigncreatureid="'+campaigncreatureid+'"]').find('.unassigncreature').remove();

	    					$('.menucharacter[campaigncreatureid="'+campaigncreatureid+'"]').click(function(){
	    						clickMenuCharacter(this);
	    					})

	    					// ok we moved them on the menu, cool - but we also need to remove them from the visual map
	    					$('#campaigncreature_'+campaigncreatureid).remove();
	    				}
	    				//console.log(result);
	    			})
				})

				$('.unassigncharacter').click(function(e){
					e.stopPropagation();
					characterid = $(this).parent().attr('characterid');
					name = $(this).parent().html();
					$.ajax({
		    			method: "GET",
		    			url: '/characters/'+characterid+'/unassign',
		    			dataType: 'json',
		    		})
	    			.done(function(result) {
	    				if (result.success) {
	    					$('.characterinroom[characterid="'+characterid+'"]').remove();

	    					$('#unassignedcharacters .charactersInRoom').append('<button class="btn menucharacter btn-success" currentroom="0" characterid="'+characterid+'"><label characterid="'+characterid+'">'+name+'</label></button>');

	    					$('.menucharacter[characterid="'+characterid+'"]').find('.unassigncharacter').remove();

	    					$('.menucharacter[characterid="'+characterid+'"]').click(function(){
	    						clickMenuCharacter(this);
	    					})

	    					// ok we moved them on the menu, cool - but we also need to remove them from the visual map
	    					$('#char_'+characterid).remove();
	    				}
	    				//console.log(result);
	    			})
				})

				$('#showaddcreature').click(function(){
					$('#addcreaturetext').val('');
					$('#addcreaturetext').show();
					$('#addcreaturetext').focus();
					$('#addcreaturelist').show();
				})



				$('#addcreaturetext').keyup(function(e) {
					if ($('#addcreaturetext').val() == '') {
						console.log('fkn here')
						// $('#addcreaturetext').focus();
						$('#addcreaturelist').hide();
						// $('#addcreaturetext').hide();
					}
					else {
      				clearTimeout(timeoutID);
      				//timeoutID = setTimeout(findMember.bind(undefined, e.target.value), 500);
      				timeoutID = setTimeout(() => findCreature(e.target.value), 500);
						}
    			});

				$('.menucharacter').click(function(){
					clickMenuCharacter(this);
				})

				$('.menuroom').mouseover(function(){
					roomid = $(this).attr('roomid');
					$('.room_'+roomid).css('opacity','0.5');
				})

				$('.menuroom').mouseout(function(){
					roomid = $(this).attr('roomid');
					$('.room_'+roomid).css('opacity','1');
				})
				// $('main').css('padding-top','0px!important');

				$('.navbar').css('z-index','100')
				$('.navbar').css('background-color','white')



				// $('#areagrid').css('position','absolute');

				// $('#areagrid').css('width','70%');
				// $('#areagrid').css('height','70%');
				// $('#areagrid').css('top','0');
				// $('#areagrid').css('right','0');

				$( "#areagrid" ).draggable();

				// $('#areagrid').css('z-index','-1');

				$('#dragZone div').click(function() {
			        $(this).addClass('top').removeClass('bottom');
			        $(this).siblings().removeClass('top').addClass('bottom');
			        $(this).css("z-index", a++);
			    });

			    initGrid();

			    // registerGridEvents();

					$('.actualroom').mouseover(function(ev){
						$('.actualroom').css('opacity','1');
						$('.actualroom').css('filter','contrast(70%)');
						$('.environment').css('opacity','1');
						$('.environment').css('filter','contrast(70%)');
						// ev.preventDefault();
						// ev.stopPropagation();
						// $('.actualroom').css('opacity','1');
						roomid = $(this).attr('roomid');
						// $('.room_'+roomid).css('opacity','0.9');
						$('.room_'+roomid).css('filter','contrast(100%)');
						$(this).css('opacity','0.5');
						$(this).find('.characterinmap').css('color','white');
						$(this).find('.characterinmap').css('opacity','1');
					})

					$('.actualroom').mouseout(function(ev){
						$(this).css('opacity','1');
					});

					$('.actualroom').click(function(){
						cellClick(this);
					});

					$('.actualroom').droppable({
						drop: function(event,ui) {
							col = $(event.target).attr('data-col');
							row = $(event.target).attr('data-row');
							roomid = $(event.target).attr('roomid');
    						characterid = $(ui.draggable).attr('characterid');
    						campaigncreatureid = $(ui.draggable).attr('campaigncreatureid');
    						//console.log('ewfdwefwef'+campaigncreatureid);
    						// this will move them to a new room on the menu after saving their new location to db
    						// if success, then move to the new spot on the map
    						if (campaigncreatureid) {
    							//console.log('moving after dfrop?');
								moveCharacter(col,row,'',roomid,campaigncreatureid)
    						}
    						else {
    							moveCharacter(col,row,characterid,roomid)
    						}

						    $(ui.draggable).appendTo(event.target);

						    charsinsquare = $('td[data-row="'+row+'"][data-col="'+col+'"] > .characterinmap').length;

							//console.log('char in square: '+charsinsquare);
							if (charsinsquare > 0) {
								// theres more than one character in the square
								// lets put a tiny number in the square
								newtop = 3 * charsinsquare;
								newleft = 3 * charsinsquare;
								if (campaigncreatureid) {
									$('#campaigncreature_'+campaigncreatureid).css('top',newtop+'px');
									$('#campaigncreature_'+campaigncreatureid).css('left',newleft+'px');
								}
								else {
									$('#char_'+characterid).css('top',newtop+'px');
									$('#char_'+characterid).css('left',newleft+'px');
								}

							}
							else {
						    	$(ui.draggable).css('top','2px');
						 		$(ui.draggable).css('left','2px');
						 	}
						}
					});


					$('.addcreature').blur(function(){
						// $(this).hide();
						$('#addcreaturelist').html();
						$('#addcreaturelist').hide();

					})

					width = parseFloat($('.actualroom').css('width'));
					height = parseFloat($('.actualroom').css('height'));



					$('#areagrid').mousewheel(function(turn, delta) {
						turn.preventDefault();

						if (delta == 1) {
							//Scrolling Down
							//console.log('down?');
							//Scrolling Up

							width = width + 1;
							height = height + 1;
							$('#areagrid td').css('width',width+'px');
							$('#areagrid td').css('height',height+'px');

						}
						else {
							//console.log('up?');
							if (width > 29 && height > 29) {
								width = width - 1;
								height = height - 1;
								//console.log('old: '+width+' '+height);
								//console.log('new: '+width+' '+height);
								$('#areagrid td').css('width',width+'px');
								$('#areagrid td').css('height',height+'px');
							}
						}
					});

					panelhidden = false;
					$('#toggleactoractionpanel button').click(function(){
						if (panelhidden == false) {
							$('#actoractionpanel').fadeOut();
							$('#toggleactoractionpanel button').html('Show Panel')
							panelhidden = true;
						}
						else {
							$('#actoractionpanel').fadeIn();
							panelhidden = false;
							$('#toggleactoractionpanel button').html('Hide Panel')
						}
					})

					helphidden = true;
					$('#togglehelp button').click(function(){
						if (helphidden == true) {
							$('.infobox').fadeIn();
							$('#togglehelp button').html('Hide Help')
							helphidden = false;
						}
						else {
							$('.infobox').fadeOut();
							$('#togglehelp button').html('Show Help')
							helphidden = true;
						}
					})

					hasgrid = false;
					$('#togglegridlines').click(function(){
						if (hasgrid == false) {
							$('#areagrid td').addClass('showgridlines');
							hasgrid = true;
						}
						else {
							$('#areagrid td').removeClass('showgridlines');
							hasgrid = false;
						}

					})

					$('#exportarea').click(function(){
						html2canvas(document.querySelector("#areagrid table")).then(canvas => {
						    imagedata = canvas.toDataURL("image/png");

						    if (newdata = imagedata.replace(/^data:image\/png/, "data:application/octet-stream")) {
						    	$.featherlight('<div><a href="'+newdata+'" download="{{$area->name}}.png">Download Image</a><img src="'+imagedata+'"></div>');
						    }
						});
					})

					$('#addcreaturetext').blur(function(){
							$('#addcreaturetext').val('');
							$('#addcreaturetext').focus();
							setTimeout(
							  function()
							  {
							    $('#addcreaturetext').keyup();
							  }, 500);

							// $('#addcreaturelist').hide();
							// $('#addcreaturetext').hide();
					})



					// $('.characterrequestinmap').click(function(event){
					// 	clickCharacterRequest(event);
					// })
					// $('#char_'+characterid.draggable();
					// $('.characterinmap').draggable();
					doPoll();
			});


			var isMouseDown = false;
			var isHighlighted;

			var startCell;
			var currentCell;

			function cellClick(thecell) {
				if ($('body').css('cursor') == 'crosshair') {
					if ($(thecell).hasClass('characterinmap')) {
						alert('There is already a character on this square!');
					}
					else {
						thecharacter = $('.charactersInRoom .selected').html();


						// console.log('this is the character: '+thecharacter);
						characterid = $(thecharacter).attr('characterid');
						campaigncreatureid = $(thecharacter).attr('campaigncreatureid');

						name = $(thecharacter).html();
						// console.log(name);
						col = $(thecell).attr('data-col');
						row = $(thecell).attr('data-row');
						roomid = $(thecell).attr('roomid');
						environmentid = '';
						if (!roomid) {
							// for now, only register environment if there is no roomid in the cell...
							environmentid = $(thecell).attr('environmentid');
						}


						// lets ajax save, if it is a success we will actually move the character
						// console.log('this is everything: '+col,row,characterid,roomid,campaigncreatureid,environmentid)
						moveCharacter(col,row,characterid,roomid,campaigncreatureid,environmentid);
						// console.log('this is a resulty from the savedchar method: '+savedcharacter);
						if (!characterid) {
							$('#campaigncreature_'+campaigncreatureid).remove();
						}
						else {
							$('#char_'+characterid).remove();
						}


						drawCharacter(col,row,name,characterid,request=null,campaigncreatureid);

						// $(thecharacter).parent().css('cursor','auto');
					}
					$('.charactersInRoom .selected').removeClass('selected');
					$('body').css('cursor','auto');
				}
				else {

				}
			}

			function findCreature(name) {
				$('#addcreaturelist').html('');
				console.log(name);
	    		$.ajax({
	    			method: "GET",
	    			url: '/searchcreatures',
	    			data: {"name":name,"_token": "{{ csrf_token() }}" },
	    			dataType: 'json',
	    		})
    			.done(function(result) {
    				$('#addcreaturelist').show();
					$(result).each(function(index,element) {
						$('#addcreaturelist').append('<button class="btn btn-danger addcreature" creatureid="'+element.id+'" id="addcreature_'+element.id+'">'+element.name+'</button>')
						$('#addcreature_'+element.id).click(function(e){
							e.stopPropagation();
							e.preventDefault();
							//console	.log('what about here???');
							addCreature(element.id,element.name);
						})
					});
    				//console.log(result);
    			})
			}

			function addCreature(id,name) {
				$('#addcreaturetext').hide();
				$('#addcreaturelist').hide();
				console.log('adding cvreature?');
				$.ajax({
	    			method: "POST",
	    			url: '/campaigncreatures',
	    			data: {"creature_id":id,"campaign_id":"{{$campaign->id}}","area_id":"{{$area->id}}","_token": "{{ csrf_token() }}" },
	    			dataType: 'json',
	    		})
    			.done(function(result) {
    				//console.log(result);
    				if (result.success) {
    					$('#unassignedcharacters .charactersInRoom').append('<button class="btn menucharacter btn-danger" campaigncreatureid="'+result.id+'" creatureid="'+id+'" currentroom="0"><label creatureid="'+id+'" campaigncreatureid="'+result.id+'">'+result.name+'</label></button>');

	    				$('.menucharacter[campaigncreatureid="'+result.id+'"]').click(function(){
							clickMenuCharacter(this);
						})

    				}
    			})
			}

			function clickMenuCharacter(menuitem) {
				$('.menucharacter').removeClass('selected');
				$(menuitem).addClass('selected');
				firstinitial = $(menuitem).find('label').html()[0];
				// console.log('first initial: '+firstinitial);
				// $('body').addClass('customcursor')
				$('body').css('cursor','crosshair');
				// $(this).css('cursor','crosshair');
				// $(this).css('background-color','grey')
			}


			function clickCharacterRequest(therequest) {
				// ok! lets get the ID, move the character (it should clear the request when the character moves)

				characterid = $(therequest).attr('characterid');
				col = $(therequest).parent().attr('data-col');
				row = $(therequest).parent().attr('data-row');

				roomid = $(therequest).parent().attr('roomid');
				environmentid = '';
				if (!roomid) {
					// for now, only register environment if there is no roomid in the cell...
					environmentid = $(therequest).parent().attr('environmentid');
				}


				name = $('#charrequest_'+characterid).html();

				// console.log('is this environment? '+environmentid);

				moveCharacter(col,row,characterid,roomid,'',environmentid)

				$('#char_'+characterid).remove();
				$('#charrequest_'+characterid).remove();
				//console.log(col,row,name,characterid);
				drawCharacter(col,row,name,characterid);
			}

			function doPoll(){

	    		$.ajax({
	    			method: "GET",
	    			url: '/checkcharacterrequests/{{$area->id}}/{{$campaign->id}}',
	    			data: {"_token": "{{ csrf_token() }}" },
	    			dataType: 'json',
	    		})
    			.done(function(result) {
    				// console.log(result);
    				if (result.success) {
    					$(result.characterrequest).each(function(index,element) {
    						if ($('#charrequest_'+element.id)[0]) {
    							// request is still there, so do nothing
    						}
    						else {
    							// display move request
    							request = true;
						    	drawCharacter(element.requested_col,element.requested_row,element.name,element.id,request);
						    }
    					});
    					// all we need to do is check each user in the campaign
    					// to see if there is a request set, if there is return all characters with requests
    					// and their coordinates. It will update them.

    					setTimeout(doPoll,2000);
    				}
    			})
			}


			function hashCode(str) { // java String#hashCode
			    var hash = 0;
			    for (var i = 0; i < str.length; i++) {
			       hash = str.charCodeAt(i) + ((hash << 5) - hash);
			    }
			    return hash;
			}

			function intToRGB(i){
			    var c = (i & 0x00FFFFFF)
			        .toString(16)
			        .toUpperCase();

			    return "00000".substring(0, 6 - c.length) + c;
			}

			function clearPanelIcons() {
				$('.actionpanelicons li').removeAttr('selected');
			    $('.actionpanelicons li').css('background-color','white');
			}

			function drawEnvironment(envrows,colour,order) {
				// console.log(envrows);
				//console.log(startcell);
				$(envrows).each(function(index,value) {
					// console.log('index:'+index);
					// console.log('valuie:'+value);
					// console.log(value);
					r = value.row;
					// console.log(colour);
					for (c = value.start_col; c < value.end_col; c++) {
						$('td[data-row="'+r+'"][data-col="'+c+'"]').addClass('environment');
						$('td[data-row="'+r+'"][data-col="'+c+'"]').addClass('environment_'+value.environment_id);
						$('td[data-row="'+r+'"][data-col="'+c+'"]').attr('environmentid',value.environment_id);
						if ($('td[data-row="'+r+'"][data-col="'+c+'"]').hasClass('actualroom')) {

						}
						else {
							$('td[data-row="'+r+'"][data-col="'+c+'"]').css('background-color','#'+colour);
							$('td[data-row="'+r+'"][data-col="'+c+'"]').css('opacity','0.5');

							$('td[data-row="'+r+'"][data-col="'+c+'"]').click(function(){
								// console.log('clicking environment');
								cellClick(this);
							})

							$('td[data-row="'+r+'"][data-col="'+c+'"]').mouseover(function(ev){
								$('.environment:not(.actualroom)').css('opacity','1');
								$('.environment:not(.actualroom)').css('filter','contrast(70%)');

								// ev.preventDefault();
								// ev.stopPropagation();
								// $('.actualroom').css('opacity','1');
								environmentid = $(this).attr('environmentid');
								// $('.room_'+roomid).css('opacity','0.9');
								$('.environment_'+environmentid).css('filter','contrast(100%)');
								$(this).css('opacity','0.5');
								$(this).find('.characterinmap').css('color','white');
								$(this).find('.characterinmap').css('opacity','1');

							})

							$('td[data-row="'+r+'"][data-col="'+c+'"]').mouseout(function(ev){
								$(this).css('opacity','1');
							});


							$('td[data-row="'+r+'"][data-col="'+c+'"]').droppable({
								drop: function(event,ui) {
									if ($(event.target).hasClass('actualroom')) {

									}
									else {
										col = $(event.target).attr('data-col');
										row = $(event.target).attr('data-row');
										environmentid = $(event.target).attr('environmentid');
			    						characterid = $(ui.draggable).attr('characterid');
			    						campaigncreatureid = $(ui.draggable).attr('campaigncreatureid');
			    						//console.log('ewfdwefwef'+campaigncreatureid);
			    						// this will move them to a new room on the menu after saving their new location to db
			    						// if success, then move to the new spot on the map
			    						if (campaigncreatureid) {
			    							//console.log('moving after dfrop?');
											moveCharacter(col,row,'','',campaigncreatureid,environmentid);
			    						}
			    						else {
			    							moveCharacter(col,row,characterid,'','',environmentid);
			    						}

									    $(ui.draggable).appendTo(event.target);

									    charsinsquare = $('td[data-row="'+row+'"][data-col="'+col+'"] > .characterinmap').length;

										//console.log('char in square: '+charsinsquare);
										if (charsinsquare > 0) {
											// theres more than one character in the square
											// lets put a tiny number in the square
											newtop = 3 * charsinsquare;
											newleft = 3 * charsinsquare;
											if (campaigncreatureid) {
												$('#campaigncreature_'+campaigncreatureid).css('top',newtop+'px');
												$('#campaigncreature_'+campaigncreatureid).css('left',newleft+'px');
											}
											else {
												$('#char_'+characterid).css('top',newtop+'px');
												$('#char_'+characterid).css('left',newleft+'px');
											}

										}
										else {
									    	$(ui.draggable).css('top','2px');
									 		$(ui.draggable).css('left','2px');
									 	}
									}
								}
							});
						}

					}
				});
			}


			function initGrid() {
			    buildTable({{$area->max_width}},{{$area->max_height}});
			    // need to do this when an area is created

			    // once built, we set the rooms
			    if ($('.roomlist').html()) {
			    	// console.log('has rooms');
			    	$('.roominlist').each(function(index,element) {

			    		if ($(this).hasClass('environmentinlist')) {

			    			// do environments before rooms, so that rooms are above
			    			environmentid = $(this).attr('environmentid');
			    			// console.log('this is the environemtnid: '+environmentid);
		    				$.ajax({
				    			method: "GET",
				    			url: "/environments/"+environmentid,
				    			dataType: 'JSON'
				    		})
			    			.done(function(result) {
			    				// console.log(result);
			    				if (result.success) {
			    					drawEnvironment(result.envrows,result.colour,result.order);

			    				}
			    			})

			    			// now we need to place characters in the environment...

			    		} else {
				    		startcell = {}
				    		endcell = {}

				    		startcell.row = $(this).attr('startrow');
				    		startcell.col = $(this).attr('startcol')
				    		endcell.row = $(this).attr('endrow')
				    		endcell.col = $(this).attr('endcol')

				    		roomid = $(this).attr('roomid');

				    		// random colour?
				    		// var randomColor = Math.floor(Math.random()*16777215).toString(16);
				    		if ($(this).attr('colour')) {
				    			randColor = $(this).attr('colour');
				    		}
				    		else {
				    			randColor = intToRGB(hashCode($(this).attr('name')));
				    		}

				    		highlightCells(startcell,endcell,false,randColor,roomid);
				    		// ok now we draw it...
				    		$(this).find('.roomextensioninlist').each(function(){
					    		startcell = {}
					    		endcell = {}

					    		startcell.row = $(this).attr('startrow');
					    		startcell.col = $(this).attr('startcol')
					    		endcell.row = $(this).attr('endrow')
					    		endcell.col = $(this).attr('endcol')
					    		highlightCells(startcell,endcell,false,randColor,roomid);
				    			clearHighlight();
				    		})

				    	}

			    		// now we draw the characters if there are any in the room...
			    		$($(this).find('.characterinroom')).each(function(i,char) {
			    			// console.log('khnouh');
			    			// console.log(char);
			    			// console.log($(this).attr('col'),$(this).attr('row'),$(this).attr('name')[0]);
			    			if ($(this).hasClass('creatureinroom')) {
			    				drawCharacter($(this).attr('col'),$(this).attr('row'),$(this).find('label').html(),'','',$(this).attr('campaigncreatureid'))
			    			}
			    			else {
			    				drawCharacter($(this).attr('col'),$(this).attr('row'),$(this).find('label').html(),$(this).attr('characterid'))
			    			}


					    	if ($(this).attr('requestedcol') && $(this).attr('requestedrow')) {
					    		// if there is a current request..
					    		//console.log('char has a requested move...');
					    		request = true;
					    		drawCharacter($(this).attr('requestedcol'),$(this).attr('requestedrow'),$(this).find('label').html(),$(this).attr('characterid'),request);
					    	}
			    		});
			    	})
			    }

			    if ($('.doorlist').html()) {
			    	//console.log('has doors');
			    	$('.doorinlist').each(function() {

			    		startcell = {}
			    		endcell = {}

			    		startcell.row = $(this).attr('startrow');
			    		startcell.col = $(this).attr('startcol')
			    		endcell.row = $(this).attr('endrow')
			    		endcell.col = $(this).attr('endcol')

			    		placement = $(this).attr('placement');
			    		hidden = $(this).attr('ishidden');
			    		locked = $(this).attr('locked');
			    		difficulty = $(this).attr('difficulty');
			    		doorid = $(this).attr('doorid');
			    		//console.log(doorid);

			    		drawDoor(startcell,endcell,hidden,locked,placement,false,doorid);
			    		// ok now we draw it...
			    	})
			    }

			    if ($('.objectlist').html()) {
			    	//console.log('has objects');
			    	$('.objectinlist').each(function() {

			    		startcell = {}
			    		endcell = {}

			    		startcell.row = $(this).attr('startrow');
			    		startcell.col = $(this).attr('startcol')
			    		endcell.row = $(this).attr('endrow')
			    		endcell.col = $(this).attr('endcol')

			    		colour = $(this).attr('colour');
			    		radius = $(this).attr('radius');
			    		roomentityid = $(this).attr('roomentityid');
			    		entityid = $(this).attr('entityid');
			    		//console.log(entityid);

			    		drawObject(startcell,endcell,colour,radius,roomentityid);
			    		// ok now we draw it...
			    	})
			    }
			}

			function highlightCells(start, end, hover = false, colour= '', roomid='') {

			    var fromRow = Math.min(start.row, end.row);
			    var toRow = Math.max(start.row, end.row);

			    var fromCol = Math.min(start.col, end.col);
			    var toCol = Math.max(start.col, end.col);


			    //console.log('fromRow ' + fromRow + ' fromCol ' + fromCol + ' ~~~ toRow ' + toRow + ' toCol ' + toCol);
			    $('#currentroom').attr('fromr',fromRow);
			    $('#currentroom').attr('fromc',fromCol);
			    $('#currentroom').attr('tor',toRow);
			    $('#currentroom').attr('toc',toCol);
			    if (roomid) {
			    	$('#currentroom').attr('roomid',roomid);
			    }
			    // $('#currentroom').html('fromRow ' + fromRow + ' fromCol ' + fromCol + ' ~~~ toRow ' + toRow + ' toCol ' + toCol);

			    clearHighlight();

			    for (i = fromRow; i <= toRow; i++) {
			        for (j = fromCol; j <= toCol; j++) {
			            $('td[data-row="' + i + '"][data-col="' + j + '"]').addClass('highlighted');

			            $('td[data-row="' + i + '"][data-col="' + j + '"]').css('opacity','1');

			            if (hover) {
			            	$('td[data-row="' + i + '"][data-col="' + j + '"]').addClass('hovering');
			            	// $('.hovering').css('background-color','white');
			            	$('.hovering').css('opacity','1');
			            }

			            if (roomid) {
			            	$('td[data-row="' + i + '"][data-col="' + j + '"]').addClass('room_'+roomid);
			            	$('td[data-row="' + i + '"][data-col="' + j + '"]').addClass('actualroom');
			            	$('td[data-row="' + i + '"][data-col="' + j + '"]').attr('roomid',roomid);
			            	if (colour) {
			            		//$('td[data-row="' + i + '"][data-col="' + j + '"]').css('background-color','#'+colour);
			            		$('.room_'+roomid).css('background-color','#'+colour);
			            	}

// below is for drawing the room borders/walls
				            	if (i == fromRow) {
				            		rowabove = i - 1;
				            		if ($('td[data-row="' + rowabove + '"][data-col="' + j + '"]').hasClass('room_'+roomid)) {
				            			$('td[data-row="' + rowabove + '"][data-col="' + j + '"]').removeClass('roomwall-bottom');
				            			$('td[data-row="' + rowabove + '"][data-col="' + j + '"]').removeClass('wall');
				            			$('td[data-row="' + rowabove + '"][data-col="' + j + '"]').removeAttr('wall');
				            		}
				            		else {
				            			$('td[data-row="' + i + '"][data-col="' + j + '"]').addClass('roomwall-top');
				            			$('td[data-row="' + i + '"][data-col="' + j + '"]').addClass('wall');
				            			$('td[data-row="' + i + '"][data-col="' + j + '"]').attr('wall','top');
				            		}
				            	}

				            	if (j == fromCol) {
				            		colleft = j - 1;
				            		if ($('td[data-row="' + i + '"][data-col="' + colleft + '"]').hasClass('room_'+roomid)) {
										$('td[data-row="' + i + '"][data-col="' + colleft + '"]').removeClass('roomwall-right');
										$('td[data-row="' + i + '"][data-col="' + colleft + '"]').removeClass('wall');
										$('td[data-row="' + i + '"][data-col="' + colleft + '"]').removeAttr('wall');
				            		}
				            		else {
				            			$('td[data-row="' + i + '"][data-col="' + j + '"]').addClass('roomwall-left');
				            			$('td[data-row="' + i + '"][data-col="' + j + '"]').addClass('wall');
				            			$('td[data-row="' + i + '"][data-col="' + j + '"]').attr('wall','left');
				            		}
				            	}

				            	if (i == toRow) {
				            		rowright = i + 1;

									if ($('td[data-row="' + rowright + '"][data-col="' + j + '"]').hasClass('room_'+roomid)) {
										$('td[data-row="' + rowright + '"][data-col="' + j + '"]').removeClass('roomwall-top');
										$('td[data-row="' + rowright + '"][data-col="' + j + '"]').removeClass('wall');
										$('td[data-row="' + rowright + '"][data-col="' + j + '"]').removeAttr('wall');
				            		}
				            		else {
				            			$('td[data-row="' + i + '"][data-col="' + j + '"]').addClass('roomwall-bottom');
				            			$('td[data-row="' + i + '"][data-col="' + j + '"]').addClass('wall');
				            			$('td[data-row="' + i + '"][data-col="' + j + '"]').attr('wall','bottom');
				            		}
				            	}

				            	if (j == toCol) {

				            		colright = j + 1;
				            		if ($('td[data-row="' + i + '"][data-col="' + colright + '"]').hasClass('room_'+roomid)) {
				            			$('td[data-row="' + i + '"][data-col="' + colright + '"]').removeClass('roomwall-left');
				            			$('td[data-row="' + i + '"][data-col="' + colright + '"]').removeClass('wall');
				            			$('td[data-row="' + i + '"][data-col="' + colright + '"]').removeAttr('wall');
				            		}
				            		else {
				            			$('td[data-row="' + i + '"][data-col="' + j + '"]').addClass('roomwall-right');
				            			$('td[data-row="' + i + '"][data-col="' + j + '"]').addClass('wall');
				            			$('td[data-row="' + i + '"][data-col="' + j + '"]').attr('wall','right');
				            		}
				            	}


			            }

			            if (colour == 'black') {
			            	$('td[data-row="' + i + '"][data-col="' + j + '"]').css('opacity','1');
			            }
			        }

			    }
			}

			function drawDoor(start, end, hidden,locked,placement,hover = false,doorid) {

			    var fromRow = Math.min(start.row, end.row);
			    var toRow = Math.max(start.row, end.row);

			    var fromCol = Math.min(start.col, end.col);
			    var toCol = Math.max(start.col, end.col);


			    //console.log('fromRow ' + fromRow + ' fromCol ' + fromCol + ' ~~~ toRow ' + toRow + ' toCol ' + toCol);
			    $('#currentroom').attr('fromr',fromRow);
			    $('#currentroom').attr('fromc',fromCol);
			    $('#currentroom').attr('tor',toRow);
			    $('#currentroom').attr('toc',toCol);
			    // $('#currentroom').html('fromRow ' + fromRow + ' fromCol ' + fromCol + ' ~~~ toRow ' + toRow + ' toCol ' + toCol);

			    clearHighlight();

			    for (i = fromRow; i <= toRow; i++) {
			        for (j = fromCol; j <= toCol; j++) {

			        	$('td[data-row="' + i + '"][data-col="' + j + '"]').addClass('door');

			            $('td[data-row="' + i + '"][data-col="' + j + '"]').addClass('door'+placement);

			            if (hidden == 1) {
			            	$('td[data-row="' + i + '"][data-col="' + j + '"]').addClass('doorhidden');
			            }

						if (locked == 1) {
			            	$('td[data-row="' + i + '"][data-col="' + j + '"]').addClass('doorlocked');
			            }

			            if (hover) {
			            	$('td[data-row="' + i + '"][data-col="' + j + '"]').addClass('hovering');
			            }

			            //console.log('this is the doorid: '+doorid)
			            if (doorid) {
			            	//console.log('ook?');
			            	$('td[data-row="' + i + '"][data-col="' + j + '"]').addClass('door_'+doorid);
			            	$('td[data-row="' + i + '"][data-col="' + j + '"]').attr('doorid',doorid);
			            	$('.door_'+doorid).css('opacity','0.5');
			            }
			        }

			    }
			}

			function drawObject(start,end,colour,radius,roomentityid) {
				//console.log('here?????'+start,end,colour,radius,roomentityid)
			    var fromRow = Math.min(start.row, end.row);
			    var toRow = Math.max(start.row, end.row);

			    var fromCol = Math.min(start.col, end.col);
			    var toCol = Math.max(start.col, end.col);


			    //console.log('fromRow ' + fromRow + ' fromCol ' + fromCol + ' ~~~ toRow ' + toRow + ' toCol ' + toCol);
			    $('#currentroom').attr('fromr',fromRow);
			    $('#currentroom').attr('fromc',fromCol);
			    $('#currentroom').attr('tor',toRow);
			    $('#currentroom').attr('toc',toCol);
			    // $('#currentroom').html('fromRow ' + fromRow + ' fromCol ' + fromCol + ' ~~~ toRow ' + toRow + ' toCol ' + toCol);

			    clearHighlight();

			    for (i = fromRow; i <= toRow; i++) {
			        for (j = fromCol; j <= toCol; j++) {

			        	if (i == fromRow && j == fromCol) {
			        		// first row, first column - top left
			        		$('td[data-row="' + i + '"][data-col="' + j + '"]').css('border-radius',radius+'% 0px 0px 0px');

					      	// $('#entity_top_left').css('border-radius',radius+'% 0px 0px 0px');
					      	// $('#entity_top_right').css('border-radius','0px '+radius+'% 0px 0px');
					      	// $('#entity_bottom_right').css('border-radius','0px 0px '+radius+'% 0px');
					      	// $('#entity_bottom_left').css('border-radius','0px 0px 0px '+radius+'%');

			        	}

			        	if (i == fromRow && j == toCol) {
			        		// first row, last column - top right
			        		$('td[data-row="' + i + '"][data-col="' + j + '"]').css('border-radius','0px '+radius+'% 0px 0px');
			        	}

						if (i == toRow && j == fromCol) {
			        		// last row, first column - bottom left
			        		$('td[data-row="' + i + '"][data-col="' + j + '"]').css('border-radius','0px 0px 0px '+radius+'%');
			        	}

						if (i == toRow && j == toCol) {
			        		// last row, first column - bottom right
			        		$('td[data-row="' + i + '"][data-col="' + j + '"]').css('border-radius','0px 0px '+radius+'% 0px');
			        	}


			        	$('td[data-row="' + i + '"][data-col="' + j + '"]').addClass('object');

			            // console.log('this is the roomentityid: '+roomentityid)
			            if (roomentityid) {
			            	// console.log('ookroomentity??');
			            	$('td[data-row="' + i + '"][data-col="' + j + '"]').addClass('roomentity_'+roomentityid);
			            	$('td[data-row="' + i + '"][data-col="' + j + '"]').attr('roomentityid',roomentityid);
			            	$('.roomentity_'+roomentityid).css('opacity','1');
			            }

			            if (colour) {
			            	$('.roomentity_'+roomentityid).css('background-color','#'+colour);
			            }
			        }

			    }
			}

			function drawCharacter(col,row,name,characterid,request=false,campaigncreatureid = null) {
				//console.log('drawing char '+name);
				if (row && col) {
					if ($('td[data-row="' + row + '"][data-col="' + col + '"]').hasClass('characterinmap')) {
						alert('character is already on this square!');
					}
					else {
						// console.log('wefwef '+row+' wedwef')
						// console.log('wwwww '+col+' wqecwe');
						// console.log('charid '+characterid);
						if (!request) {
							//console.log('td[data-row="' + row + '"][data-col="' + col + '"]');
							// console.log('<label class="characterinmap" id="char_'+characterid+'" characterid="'+characterid+'">'+name+'</label>');
							if (campaigncreatureid) {
								appendcode = '<label class="characterinmap creatureinmap" id="campaigncreature_'+campaigncreatureid+'" campaigncreatureid="'+campaigncreatureid+'">'+name+'</label>';
							}
							else {
								appendcode = '<label class="characterinmap" id="char_'+characterid+'" characterid="'+characterid+'">'+name+'</label>';
							}

							$('td[data-row="'+row+'"][data-col="'+col+'"]').append(appendcode);
							// we need to make the character movable
							charsinsquare = $('td[data-row="'+row+'"][data-col="'+col+'"] > .characterinmap').length;

							//console.log('char in square: '+charsinsquare);
							if (charsinsquare > 0) {
								// theres more than one character in the square
								// lets put a tiny number in the square
								newtop = 3 * charsinsquare;
								newleft = 3 * charsinsquare;
								if (campaigncreatureid) {
									$('#campaigncreature_'+campaigncreatureid).css('top',newtop+'px');
									$('#campaigncreature_'+campaigncreatureid).css('left',newleft+'px');
								}
								else {
									$('#char_'+characterid).css('top',newtop+'px');
									$('#char_'+characterid).css('left',newleft+'px');
								}
							}

							if (campaigncreatureid) {
								$('#campaigncreature_'+campaigncreatureid).draggable({
									revert: "invalid"
								});
							}
							else {
								$('#char_'+characterid).draggable({
									revert: "invalid"
								});
							}
						}
						else {
							// remove character request if it exists
							$('#charrequest_'+characterid).remove();
							// then add a now one on this square
							$('td[data-row="'+row+'"][data-col="'+col+'"]').append('<label class="characterinmap characterrequestinmap" id="charrequest_'+characterid+'" characterid="'+characterid+'" isyou="true">'+name+'</label>');

							// we need to make the character movable
							charsinsquare = $('td[data-row="'+row+'"][data-col="'+col+'"] > .characterinmap').length;

							//console.log('char in square: '+charsinsquare);
							if (charsinsquare > 0) {
								// theres more than one character in the square
								// lets put a tiny number in the square
								newtop = (2 * charsinsquare) - 5;
								newleft = (2 * charsinsquare) - 5;
								$('#charrequest_'+characterid).css('top',newtop+'px');
								$('#charrequest_'+characterid).css('left',newleft+'px');
							}

							$('#charrequest_'+characterid).click(function(){
								therequest = this;
								clickCharacterRequest(therequest);
							});
						}
					}
				}
				else {
					alert('Cant place character here');
				}
			}

			function moveCharacter(col,row,characterid,roomid,campaigncreatureid = null,environmentid = null) {
				if (!campaigncreatureid) {
		    		$.ajax({
		    			method: "PUT",
		    			url: "/characters/"+characterid,
		    			data: {"col": col, "row": row, "roomid": roomid, "environmentid": environmentid,"_token": "{{ csrf_token() }}" },
		    			dataType: 'json',
		    		})
	    			.done(function(result) {
	    				//console.log(result);
	    				if (result == 'true') {
	    					// $('.charactersInRoom .menucharacter[characterid="'+characterid+'"]').append('<span class="close unassigncharacter">x</span>');
	    					if (environmentid) {
								$('.charactersInRoom .menucharacter[characterid="'+characterid+'"]').appendTo('.menuroom[environmentid="'+environmentid+'"] .charactersInRoom');
	    					}
	    					else {
	    						$('.charactersInRoom .menucharacter[characterid="'+characterid+'"]').appendTo('.menuroom[roomid="'+roomid+'"] .charactersInRoom');
	    					}

	    					//
	    				}
	    			})
	    		}
	    		else {
	    			//console.log('its a creature not a char!');
	    			$.ajax({
		    			method: "PUT",
		    			url: "/campaigncreatures/"+campaigncreatureid,
		    			data: {"col": col, "row": row, "roomid": roomid, "environmentid":environmentid,"_token": "{{ csrf_token() }}" },
		    			dataType: 'json',
		    		})
	    			.done(function(result) {
	    				//console.log(result);
	    				if (result == 'true') {
	    					// $('.charactersInRoom .menucharacter[campaigncreatureid="'+campaigncreatureid+'"]').append('<span class="close unassigncreature">x</span>')
	    					// $('.charactersInRoom .menucharacter[campaigncreatureid="'+campaigncreatureid+'"] .unassignedcreature').click(function(){})
	    					if (environmentid) {
	    						$('.charactersInRoom .menucharacter[campaigncreatureid="'+campaigncreatureid+'"]').appendTo('.menuroom[environmentid="'+environmentid+'"] .charactersInRoom')
	    					}
	    					else {
	    						$('.charactersInRoom .menucharacter[campaigncreatureid="'+campaigncreatureid+'"]').appendTo('.menuroom[roomid="'+roomid+'"] .charactersInRoom')
	    					}
	    					// <span class="close unassigncharacter">x</span>
	    				}
	    			})
	    		}
			}

			function clearHighlight() {
			    $('td').removeClass('hovering');
			    $('td').removeClass('highlighted');
			    // $('td').css('border-radius','0px');
			}


			function getCellPosition($cell) {
			    var cell = {
			        row: $cell.data('row'),
			        col: $cell.data('col')
			    }
			    return cell;
			}

			function buildTable(width,height) {
			    var tableHtml = '';
			    tableHtml = '<table cellpadding="0" cellspacing="0" style="width: 100%">';
			    for (i = 0; i < height; i++) {
			        tableHtml += '<tr>';
			        for (j = 0; j < width; j++) {
			            tableHtml += '<td data-row="' + i + '" data-col="' + j + '"></td>';
			        }
			        tableHtml += '</tr>';
			    }
			    tableHtml += '</table>';
			    $('#areagrid').html(tableHtml);
			}
	</script>
@endsection
