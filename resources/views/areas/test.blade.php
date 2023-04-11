@extends('layouts.adminnoheader')

@section('content')
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<?php $erroronpage = false; $errormessage = ''; ?>

	@if ($character->campaign)
		@if ($character->room)
			<?php
				$area = \App\Models\Room::find($character->room_id)->area;
				$campaign = $character->campaign;
				// $area = $character->room->area;
				// $campaign = \App\Models\Campaign::find($character->campaign_id);
				// $campaign = $character->campaign();
				// $area = \App\Models\Area::find($area->id);
			?>
		@else
			<?php $erroronpage = true; $errormessage = "Campaign does not have an Area! Contact your DM and get it sorted!"; ?>
		@endif
	@else 
		<?php $erroronpage = true; $errormessage = "Character does not belong to a Campaign! Contact your DM and get it sorted!"; ?>
	@endif

	@if (!isset($character->campaign))
		
	@endif
	
	@if (!$erroronpage)
		@if ($area->doors->first())
			<ul class="doorlist hiddenlist">
				<li><h3>Doors in Area:</h3></li>
				@foreach ($area->doors as $door)
					<li class="doorinlist" name="door_{{$door->id}}" doorid="{{$door->id}}" startrow="{{$door->start_row}}" startcol="{{$door->start_col}}" endrow="{{$door->end_row}}" endcol="{{$door->end_col}}" locked="{{$door->locked}}" ishidden="{{$door->hidden}}" difficulty="@isset($door->difficulty) {{$door->difficulty}} @else 0 @endisset" placement="{{$door->placement}}"><button class="btn btn-primary" >Door{{$door->id}} <span class="deletedoor" doorid="{{$door->id}}"><i class="fas fa-times"></i></span></button></a></li>
				@endforeach
			</ul>
		@endif

		@if ($character->rooms->first())
			<ul class="objectlist hiddenlist">
				<li><h3>Objects in Area: </h3></li>
				@foreach ($character->rooms as $room)

					@foreach ($room->roomentities as $roomentity)
						<li class="objectinlist" name="{{$roomentity->entity->name}}" roomentityid="{{$roomentity->id}}" startrow="{{$roomentity->offset_row}}" startcol="{{$roomentity->offset_col}}" endrow="{{$roomentity->getEndRow()}}" endcol="{{$roomentity->getEndCol()}}" colour="{{$roomentity->entity->colour}}" radius="{{$roomentity->entity->cornerradius}}"><button class="btn btn-primary" >{{$roomentity->entity->name}}_{{$roomentity->id}} ({{$room->name}}) <span class="deleteroomentity" roomid="{{$room->id}}" roomentityid="{{$roomentity->id}}"><i class="fas fa-times"></i></span></button></a></li>
					@endforeach
				@endforeach
			</ul>
		@endif
	@endif


	<div class="row initiativepanel">
		<div class="col mainpanel" id="initiativepanel">
			@if ($erroronpage)
				{{$errormessage}}
			@endif
		</div>
	</div>

	@if (!$erroronpage)
	    <div class="row mainpanels hiddenlist">
	    	<div class="col mainpanel list-group" id="actoractionpanel">

	    		ActorAction Panel
		    		<ul class="roomsInArea list-group roomlist">
		    			@foreach ($character->rooms as $room)
		    				<li class="list-group-item menuroom roominlist" name="{{$room->name}}" roomid="{{$room->id}}" startrow="{{$room->start_row}}" startcol="{{$room->start_col}}" endrow="{{$room->end_row}}" endcol="{{$room->end_col}}" @if ($character->room_id == $room->id) activeroom="true" @endif>
		    					<label>{{$room->name}}</label>
		    				</li>
		    			@endforeach
		    		</ul>
					 <ul class="charactersInRoom list-group">
					@foreach ($campaign->characters as $acharacter)
						@if ($character->room_id == $acharacter->room_id)
							<button class="list-group-item menucharacter characterinroom" col="@isset($acharacter->current_col){{$acharacter->current_col}}@endisset" row="@isset($acharacter->current_row){{$acharacter->current_row}}@endisset" requestedrow="@isset($acharacter->requested_row){{$acharacter->requested_row}}@endisset" requestedcol="@isset($acharacter->requested_col){{$acharacter->requested_col}}@endisset" characterid="{{$acharacter->id}}" currentroom="{{$acharacter->room_id}}"><label characterid="{{$acharacter->id}}">{{$acharacter->name}}</label></button>
						@endif
					@endforeach
					</ul>

	    	</div>
	        <div class="col-8 mainpanel" id="mappanel">
	        	<span id="currentroom"></span>
	        </div>

	        <div class="col mainpanel" id="dicelogpanel">
	        	Dice Log
	        </div>
    	</div>
	    <div class="row floatingmapcontainer">
			<div id="areagrid" areaid="{{$area->id}}"></div>
	    </div>
	 @endif
@endsection

@section("scripts")
	<script>
			$(document).ready(function () {

				$.ajaxSetup({
				    headers: {
				        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				    }
				});
				
				

				$('.menucharacter').click(function(){
					$('.menucharacter').removeClass('selected');
					$(this).addClass('selected');
					firstinitial = $(this).find('label').html()[0];
					// console.log('first initial: '+firstinitial);
					// $('body').addClass('customcursor')
					$('body').css('cursor','crosshair');
					// $(this).css('cursor','crosshair');
					// $(this).css('background-color','grey')
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

				$('#areagrid').css('position','absolute');
				
				// $('#areagrid').css('width','70%');
				// $('#areagrid').css('height','70%');
				$('#areagrid').css('top','0');
				$('#areagrid').css('right','0');

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
					$('.historicroom').css('filter','grayscale(100%)');
					$('.characterrequestinmap').css('filter','grayscale(0%)');
					// $('.characterrequestinmap').css('opacity','0.2');
					// ev.preventDefault();
					// ev.stopPropagation();
					// $('.actualroom').css('opacity','1');
					roomid = $(this).attr('roomid');
					// $('.room_'+roomid).css('opacity','0.9');
					$('.room_'+roomid).css('filter','contrast(100%)');

					// $('.room_'+roomid).css('filter','grayscale(100%)');
					// $(this).css('opacity','0.8');
					$(this).find('.characterinmap').css('color','white');
					$(this).find('.characterinmap').css('opacity','1');
						
				})

				$('.actualroom').click(function(event) {
						col = $(this).attr('data-col');
						row = $(this).attr('data-row');
						roomid = $(this).attr('roomid');
						
						characterid = {{$character->id}};
						name = $('#char_'+characterid).html();
						request = true;
						console.log(col,row,characterid,roomid);
						requestMoveCharacter(col,row,characterid,roomid)
					    drawCharacter(col,row,name,characterid,request);
				});

				doPoll();
					// $('#char_'+characterid.draggable();
					// $('.characterinmap').draggable();
			});


			var isMouseDown = false;
			var isHighlighted;

			var startCell;
			var currentCell;

			function doPoll(){
				currentroomid = $('.characterinmap[isyou="true"]').parent().attr('roomid');
	    		$.ajax({
	    			method: "GET",
	    			url: '/checkupdates/{{$character->id}}/currentroomid',
	    			data: {"_token": "{{ csrf_token() }}" },
	    			dataType: 'json',
	    		})
    			.done(function(result) {
    				console.log(result);
    				if (result.success) {
    					
    					if (result.characterupdated && result.characterupdated.room_id != currentroomid) {
    						// your character has been moved to a new room!!
    						// move your character, but delete the other characters in the current room
    						// then redraw the characters that are in the new room!
    						// $('.characterinmap').remove();

    						$('.actualroom').removeClass('activeroom');
							$('.room_'+currentroomid).addClass('historicroom');
							$('.historicroom').css('filter','grayscale(100%)');

    						// ok we need to check if the new room exists!!!
    						if ($('.room_'+result.characterupdated.room_id)[0]) {
    							
    							$('.room_'+result.characterupdated.room_id).addClass('activeroom');
    							

    						}
    						else {
    							// class doesnt exist, so lets create it.
    							console.log('it doesnt exist!!');

    							startcell = {}
			    				endcell = {}
			    				startcell.row = result.room.startrow;
			    				startcell.col = result.room.startcol;
			    				endcell.row = result.room.endrow;
			    				endcell.col = result.room.endcol;
			    				activeroom = true;

								randColor = intToRGB(hashCode(result.room.name));

    							highlightCells(startcell,endcell,false,randColor,result.characterupdated.room_id,activeroom);
    						}

    						$('.activeroom').css('filter','grayscale(0%)');
    						$('.activeroom').removeClass('historicroom');

    						// drawCharacter(result.characterupdated.current_col,result.characterupdated.current_row,result.characterupdated.name,result.characterupdated.id);
    					}

    					if (result.characterupdated && !result.characterupdated.requested_col) {
    						// remove the requested icon
    						$('.characterrequestinmap').remove();
    					}

    					// need to do a foreach of all the characters that have updated
    					if (result.updatedroomcharacters) {
    						$('.characterinmap:not(.characterrequestinmap)').remove();
    						$(result.updatedroomcharacters).each(function(index,element) {
									console.log(element.current_col,element.current_row,element.name,element.id);
									drawCharacter(element.current_col,element.current_row,element.name,element.id);
    						})
    						// $('.characterinmap').remove();
    					}

    					setTimeout(doPoll,5000);
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

			function initGrid() {
			    buildTable(70);
			    // need to do this when an area is created

			    // once built, we set the rooms
			    if ($('.roomlist').html()) {
			    	console.log('has rooms');
			    	$('.roominlist').each(function(index,element) {

			    		startcell = {}
			    		endcell = {}

			    		startcell.row = $(this).attr('startrow');
			    		startcell.col = $(this).attr('startcol')
			    		endcell.row = $(this).attr('endrow')
			    		endcell.col = $(this).attr('endcol')

			    		roomid = $(this).attr('roomid');

			    		// random colour?
			    		// var randomColor = Math.floor(Math.random()*16777215).toString(16);
			    		randColor = intToRGB(hashCode($(this).attr('name')));
			    		activeroom = false;
			    		if ($(this).attr('activeroom')) {
			    			activeroom = true;
			    		}
			    		highlightCells(startcell,endcell,false,randColor,roomid,activeroom);
			    		// ok now we draw it...

			    		// now we draw the characters if there are any in the room...
			    	})
			    }

			    $($('.characterinroom')).each(function(i,char) {
			    	console.log('khnouh');
			    	console.log(char);
			    	// console.log($(this).attr('col'),$(this).attr('row'),$(this).attr('name')[0]);
			    	drawCharacter($(this).attr('col'),$(this).attr('row'),$(this).find('label').html(),$(this).attr('characterid'))

			    	if ($(this).attr('requestedcol') && $(this).attr('requestedrow')) {
			    		// if there is a current request..
			    		request = true;
			    		drawCharacter($(this).attr('requestedcol'),$(this).attr('requestedrow'),$(this).find('label').html(),$(this).attr('characterid'),request);
			    	} 
			    });

			    if ($('.doorlist').html()) {
			    	console.log('has doors');
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
			    		console.log(doorid);

		    			drawDoor(startcell,endcell,hidden,locked,placement,false,doorid);

			    		// ok now we draw it...
			    	})
			    }

			    if ($('.objectlist').html()) {
			    	console.log('has objects');
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
			    		console.log(entityid);

			    		drawObject(startcell,endcell,colour,radius,roomentityid);
			    		// ok now we draw it...
			    	})
			    }
			}

			function highlightCells(start, end, hover = false, colour= '', roomid='', activeroom=false) {

			    var fromRow = Math.min(start.row, end.row);
			    var toRow = Math.max(start.row, end.row);

			    var fromCol = Math.min(start.col, end.col);
			    var toCol = Math.max(start.col, end.col);


			    console.log('fromRow ' + fromRow + ' fromCol ' + fromCol + ' ~~~ toRow ' + toRow + ' toCol ' + toCol);
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

			            $('td[data-row="' + i + '"][data-col="' + j + '"]').css('opacity','0.8');

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
			            		if (!activeroom) {
			            			$('.room_'+roomid).addClass('historicroom');
			            			$('.room_'+roomid).css('filter','grayscale(100%)');
			            		}
			            		else {
			            			$('.room_'+roomid).addClass('activeroom');
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


			    console.log('fromRow ' + fromRow + ' fromCol ' + fromCol + ' ~~~ toRow ' + toRow + ' toCol ' + toCol);
			    $('#currentroom').attr('fromr',fromRow);
			    $('#currentroom').attr('fromc',fromCol);
			    $('#currentroom').attr('tor',toRow);
			    $('#currentroom').attr('toc',toCol);
			    // $('#currentroom').html('fromRow ' + fromRow + ' fromCol ' + fromCol + ' ~~~ toRow ' + toRow + ' toCol ' + toCol);

			    clearHighlight();

			    for (i = fromRow; i <= toRow; i++) {
			        for (j = fromCol; j <= toCol; j++) {
			        	if ($('td[data-row="' + i + '"][data-col="' + j + '"]').hasClass('actualroom')) {
			        		// only draw the door if it is in a room
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

				            console.log('this is the doorid: '+doorid)
				            if (doorid) {
				            	console.log('ook?');
				            	$('td[data-row="' + i + '"][data-col="' + j + '"]').addClass('door_'+doorid);
				            	$('td[data-row="' + i + '"][data-col="' + j + '"]').attr('doorid',doorid);
				            	$('.door_'+doorid).css('opacity','0.5');
				            }
				        }
			        }

			    }
			}

			function drawObject(start,end,colour,radius,roomentityid) {
				console.log('here?????'+start,end,colour,radius,roomentityid)
			    var fromRow = Math.min(start.row, end.row);
			    var toRow = Math.max(start.row, end.row);

			    var fromCol = Math.min(start.col, end.col);
			    var toCol = Math.max(start.col, end.col);


			    console.log('fromRow ' + fromRow + ' fromCol ' + fromCol + ' ~~~ toRow ' + toRow + ' toCol ' + toCol);
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
			            	// $('.roomentity_'+roomentityid).css('filter','grayscale(100%)');
			            }
			        }

			    }				
			}

			function drawCharacter(col,row,name,characterid,request=false) {
				console.log('drawing char '+name);
				if (row && col) {
					if ($('td[data-row="' + row + '"][data-col="' + col + '"]').hasClass('characterinmap')) {
						alert('character is already on this square!');
					}
					else {
						// console.log('wefwef '+row+' wedwef')
						// console.log('wwwww '+col+' wqecwe');
						// console.log('charid '+characterid);
						console.log('td[data-row="' + row + '"][data-col="' + col + '"]');
						isyou = '';
						if (characterid == {{$character->id}}) {
							// it is you
							isyou = 'true';
						}
						// console.log('<label class="characterinmap" id="char_'+characterid+'" characterid="'+characterid+'">'+name+'</label>');
						if (!request) {
							$('td[data-row="'+row+'"][data-col="'+col+'"]').append('<label class="characterinmap" id="char_'+characterid+'" characterid="'+characterid+'" isyou="'+isyou+'">'+name+'</label>');

							// we need to make the character movable
							charsinsquare = $('td[data-row="'+row+'"][data-col="'+col+'"] > .characterinmap').length;

							console.log('char in square: '+charsinsquare);
							if (charsinsquare > 0) {
								// theres more than one character in the square
								// lets put a tiny number in the square
								newtop = 3 * charsinsquare;
								newleft = 3 * charsinsquare;
								$('#char_'+characterid).css('top',newtop+'px');
								$('#char_'+characterid).css('left',newleft+'px');
							}
						}
						else {
							// remove character request if it exists
							$('#charrequest_'+characterid).remove();
							// then add a now one on this square
							$('td[data-row="'+row+'"][data-col="'+col+'"]').append('<label class="characterinmap characterrequestinmap" id="charrequest_'+characterid+'" characterid="'+characterid+'" isyou="true">'+name+'</label>');
							
							// we need to make the character movable
							charsinsquare = $('td[data-row="'+row+'"][data-col="'+col+'"] > .characterinmap').length;

							console.log('char in square: '+charsinsquare);
							if (charsinsquare > 0) {
								// theres more than one character in the square
								// lets put a tiny number in the square
								newtop = (2 * charsinsquare) - 5;
								newleft = (2 * charsinsquare) - 5;
								$('#charrequest_'+characterid).css('top',newtop+'px');
								$('#charrequest_'+characterid).css('left',newleft+'px');
							}
						}


						// $('#char_'+characterid+'[isyou="true"]').draggable({
						// 	revert: "invalid"
						// });
					}
				}
				else {
					alert('Cant place character here');
				}
				
			}

			function requestMoveCharacter(col,row,characterid,roomid) {
	    		$.ajax({
	    			method: "PUT",
	    			url: "/characters/"+characterid,
	    			data: {"requested_col": col, "requested_row": row, "roomid": roomid, "_token": "{{ csrf_token() }}" },
	    			dataType: 'json',
	    		})
    			.done(function(result) {
    				console.log(result);
    				if (result == 'true') {
    					//$('.charactersInRoom .menucharacter[characterid="'+characterid+'"]').appendTo('.menuroom[roomid="'+roomid+'"] .charactersInRoom')
    				}
    			})
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

			function buildTable(size) {
			    var tableHtml = '';
			    tableHtml = '<table cellpadding="0" cellspacing="0">';
			    for (i = 0; i < size; i++) {
			        tableHtml += '<tr>';
			        for (j = 0; j < size; j++) {
			            tableHtml += '<td data-row="' + i + '" data-col="' + j + '"></td>';
			        }
			        tableHtml += '</tr>';
			    }
			    tableHtml += '</table>';
			    $('#areagrid').html(tableHtml);
			}


	</script>
@endsection