@extends('layouts.admin')

@section('content')
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<div id="createdoordialog" title="Create Door" class="hiddendialog">
		<form action="/doors" method="post" id="createdoorform">
            @csrf
            <input type="hidden" name="area_id" id="area_id" value="{{$area->id}}">
            <input type="hidden" name="door_start_row" id="door_start_row">
            <input type="hidden" name="door_start_col" id="door_start_col">
            <input type="hidden" name="door_end_row" id="door_end_row">
            <input type="hidden" name="door_end_col" id="door_end_col">
            <input type="hidden" name="placement" id="placement">
            <div class="form-group">
                <label for="locked">Locked?</label>
                <input type="checkbox" class="form-control" id="locked" name="locked" aria-describedby="locked">
            </div>
            <div class="form-group">
            <div class="form-group">
                <label for="hidden">Hidden?</label>
                <input type="checkbox" class="form-control" id="hidden" name="hidden" aria-describedby="hidden">
            </div>
                <label for="difficulty">Difficulty</label>
                <input type="text" class="form-control" id="difficulty" name="difficulty" aria-describedby="difficulty" placeholder="Enter locked Door Difficulty Check">
            </div>


            <div>
                <button class="btn btn-primary" type="submit">Create Door</button>
            </div>
		</form>
	</div>

	<div id="createentitydialog" title="Create Room Object" class="hiddendialog">
		<form action="/entities" method="post">
            @csrf
            <input type="hidden" name="area_id" id="area_id" value="{{$area->id}}">
            <input type="hidden" name="entity_room_id" id="entity_room_id">
            <input type="hidden" name="entity_start_row" id="entity_start_row">
            <input type="hidden" name="entity_start_col" id="entity_start_col">
            <input type="hidden" name="entity_end_row" id="entity_end_row">
            <input type="hidden" name="entity_end_col" id="entity_end_col">
            <input type="hidden" name="entity_height" id="entity_height">
            <input type="hidden" name="entity_width" id="entity_width">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="entity_name" name="entity_name" aria-describedby="entity_name" placeholder="Name of the Object">
            </div>

            <div class="form-group">
                <label for="name">Colour</label>
                <input type="text" class="form-control" id="entity_colour" name="entity_colour" aria-describedby="entity_colour" placeholder="Choose Colour">
            </div>

            <div class="form-group">
                <label for="name">Corner Curve</label>
                <input type="text" class="form-control" id="entity_cornerradius" name="entity_cornerradius" aria-describedby="entity_cornerradius" placeholder="Value 1 - 100" value="0">
            </div>

            <div id="objectpreview">

            </div>

            <div>
                <button class="btn btn-primary" type="submit">Create Object</button>
            </div>
		</form>
	</div>


	<div id="createroomdialog" title="Create Room" class="hiddendialog">
		<form action="/rooms" method="post" id="createroomform">
            @csrf
            <input type="hidden" name="area_id" id="area_id" value="{{$area->id}}">
            <input type="hidden" name="start_row" id="start_row">
            <input type="hidden" name="start_col" id="start_col">
            <input type="hidden" name="end_row" id="end_row">
            <input type="hidden" name="end_col" id="end_col">
            <div class="form-group">
                <label for="name">Room Name</label>
                <input type="text" class="form-control" id="name" name="name" aria-describedby="name" placeholder="Enter the name for the new Room">
            </div>
            <div class="form-group">
                <label for="name">Colour</label>
                <input type="text" class="form-control" id="room_colour" name="colour" aria-describedby="room_colour" placeholder="Choose Colour">
            </div>
            <div class="form-group">
                <label for="name">Description</label>
                <textarea class="form-control" id="room_description" name="description" aria-describedby="room_description" placeholder="Enter Room Description"></textarea>
            </div>
            <div>
                <button class="btn btn-primary" type="submit">Create Room</button>
            </div>
		</form>
	</div>

	<div id="editroomdialog" title="Edit Room" class="hiddendialog">
		<form action="/rooms" method="post">
            @csrf
            <input name="_method" type="hidden" value="PUT">
            <div class="form-group">
                <label for="name">Room Name</label>
                <input type="text" class="form-control" id="editroomname" name="name" aria-describedby="name" placeholder="Enter the name for the new Room">
            </div>
            <div class="form-group">
                <label for="name">Colour</label>
                <input type="text" class="form-control" id="editroom_colour" name="colour" aria-describedby="room_colour" placeholder="Choose Colour">
            </div>
            <div class="form-group">
                <label for="name">Description</label>
                <textarea class="form-control" id="editroom_description" name="description" aria-describedby="room_description" placeholder="Enter Room Description">
                </textarea>
            </div>
            <div>
								<button class="btn btn-success" id="listentoroom">Listen to Description</button>
                <button class="btn btn-primary" type="submit">Save Room</button>
            </div>
		</form>
	</div>

	<div id="createenvironmentdialog" title="Create Environment" class="hiddendialog">
		<form action="/environments" method="post">
            @csrf
            <input type="hidden" name="area_id" id="area_id" value="{{$area->id}}">

			<input type="hidden" name="environment_rows[]" id="environment_rows">

            <div class="form-group">
                <label for="name">Environment Name</label>
                <input type="text" class="form-control" id="name" name="name" aria-describedby="name" placeholder="e.g. River/Grassland/CountryRoad">
            </div>

            <div class="form-group">
                <label for="name">Colour</label>
                <input type="text" class="form-control" id="environment_colour" name="environment_colour" aria-describedby="environment_colour" placeholder="Choose Colour">
            </div>

            <div>
                <button class="btn btn-primary" type="submit">Create Environment</button>
            </div>
		</form>
	</div>

	<div id="createareadialog" title="Create Area" class="hiddendialog">
		<form action="/areas" method="post">
            @csrf
            <div class="form-group">
                <label for="name">Area (Dungeon) Name</label>
                <input type="text" class="form-control" id="name" name="name" aria-describedby="name" placeholder="Enter the name for the Area/Dungeon">
            </div>
            <div>
                <button class="btn btn-primary" type="submit">Create Area</button>
            </div>
		</form>
	</div>

	<div id="allcontainers">
		<ul class="arealist clearfix">
			<li id="toggleareapanels">
				<button class="btn btn-danger">Show Panels</button>
			</li>
			<li><button class="btn-success btn clearfix" id="createarea">Create Area</button></li>
			@foreach ($areas as $thearea)
				<li><a href="/areas/{{$thearea->id}}"><button class="btn @if ($area->id == $thearea->id) btn-info @else btn-primary @endif ">{{$thearea->name}}</button></a></li>
			@endforeach
			<li> - </li>
			<li><button class="btn btn-warning" id="togglegridlines">Toggle Gridlines</button></li>
			<li><button class="btn btn-danger" id="exportarea">Export to PNG</button></li>
		</ul>
		<ul class="campaignlist clearfix">
			<li>Campaigns using Area: </li>
			@foreach (Auth::user()->campaigns as $campaign)
				<li class="campaigninlist">
					<label class="checkbox-inline">
	      				<input type="checkbox" class="form-check-input campaigncheckbox" id="campaign{{$campaign->id}}" campaignid="{{$campaign->id}}" areaid="{{$area->id}}" @if ($campaign->areas()->where('area_id',$area->id)->first()) checked ischecked="true" @else ischecked="false" @endif >
	      				{{$campaign->name}}
	    			</label>
				</li>
			@endforeach
		</ul>

		@if ($area->environments->first())
			<ul class="environmentlist clearfix minorpanel">
				<li><p>Environments in Area:</p></li>
				@foreach ($area->environments as $environment)
					<li class="environmentinlist" name="{{$environment->name}}" environmentid="{{$environment->id}}"><button class="btn btn-primary">{{$environment->name}} <span class="deleteenvironment" environmentid="{{$environment->id}}"><i class="fas fa-times"></i></span></button></a></li>
				@endforeach
			</ul>
		@endif

		<ul class="roomlist clearfix minorpanel">
			<p style="color: red; font-weight: bold">** CLICK AN EXISTING ROOM TO DRAW AN EXTENSION **</p>
			<li><p>Rooms in Area:</p></li>
			@foreach ($area->rooms as $room)
				<li class="roominlist" name="{{$room->name}}" roomid="{{$room->id}}" startrow="{{$room->start_row}}" startcol="{{$room->start_col}}" endrow="{{$room->end_row}}" endcol="{{$room->end_col}}" colour="{{$room->colour}}">
					<span style="display:none" class="description">{{$room->description}}</span>
					<button class="btn btn-primary">
						<span class="editroom" roomid="{{$room->id}}">
						<i class="fas fa-edit"></i>
					</span>
					<span class="roomname"> {{$room->name}} </span>
					<span class="deleteroom" roomid="{{$room->id}}">
						<i class="fas fa-times"></i>
					</span>
				</button></a>

					@if ($room->extensions->first())
						<ul class="roomextensionlist clearfix minorpanel hiddenpanel" style="display: none">
							@foreach ($room->extensions as $roomext)
								<li class="roomextensioninlist" name="{{$room->name}}" roomid="{{$room->id}}" startrow="{{$roomext->start_row}}" startcol="{{$roomext->start_col}}" endrow="{{$roomext->end_row}}" endcol="{{$roomext->end_col}}" colour="{{$roomext->colour}}"></li>
							@endforeach
						</ul>
					@endif
				</li>
			@endforeach
		</ul>




		<ul class="doorlist clearfix minorpanel">
			<li><p>Doors in Area:</p></li>
			@foreach ($area->doors as $doorindex=>$door)
				<li class="doorinlist" name="door_{{$door->id}}" doorid="{{$door->id}}" startrow="{{$door->start_row}}" startcol="{{$door->start_col}}" endrow="{{$door->end_row}}" endcol="{{$door->end_col}}" locked="{{$door->locked}}" ishidden="{{$door->hidden}}" difficulty="@isset($door->difficulty) {{$door->difficulty}} @else 0 @endisset" placement="{{$door->placement}}"><button class="btn btn-primary" >Door{{$doorindex+1}} <span class="deletedoor" doorid="{{$door->id}}"><i class="fas fa-times"></i></span></button></a></li>
			@endforeach
		</ul>

		@if ($area->rooms->first())
			<ul class="objectlist clearfix minorpanel">
				<li><p>Objects in Area: </p></li>
				@foreach ($area->rooms as $room)
					@foreach ($room->roomentities as $entityindex=>$roomentity)
						<li class="objectinlist" name="{{$roomentity->entity->name}}" roomentityid="{{$roomentity->id}}" startrow="{{$roomentity->offset_row}}" startcol="{{$roomentity->offset_col}}" endrow="{{$roomentity->getEndRow()}}" endcol="{{$roomentity->getEndCol()}}" colour="{{$roomentity->entity->colour}}" radius="{{$roomentity->entity->cornerradius}}"><button class="btn btn-primary" >{{$roomentity->entity->name}} ({{$room->name}}) <span class="deleteroomentity" roomid="{{$room->id}}" roomentityid="{{$roomentity->id}}"><i class="fas fa-times"></i></span></button></a></li>
					@endforeach
				@endforeach
			</ul>
		@endif

		<div class="actionpanel">
			{{-- <p>Click a Button below, then hold down mouse button on map to draw</p> --}}
			<ul class="actionpanelicons">
				<li id="environmenticon"><button class="btn btn-danger">ENVIRONMENT</button></li>
				<li id="roomicon"><button class="btn btn-danger">ROOM</button></li>
				<li id="dooricon"><button class="btn btn-danger">DOOR</button></li>
				<li id="entityicon"><button class="btn btn-danger">OBJECT</button></li>
				<li id="dragicon"><i class="far fa-hand-paper"></i></li>
			</ul>
		</div>

		<span id="currentroom"></span>
	</div>

	<div id="areagrid" areaid="{{$area->id}}"></div>

@endsection

@section("scripts")
	<script src="/js/mousewheel/jquery.mousewheel.js"></script>
	<script src="/js/html2canvas.js"></script>
	<script>
			$(document).ready(function () {

				// area dimensions
				maxwidth = {{$area->max_width}};
				maxheight = {{$area->max_height}};

				// heightr and width of each cell in px
				width = 16;
				height = 16;

				$.ajaxSetup({
				    headers: {
				        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				    }
				});

				$('#listentoroom').click(function(e){
					e.preventDefault();
					roomid = $('#listentoroom').attr('roomid');
					// description = $('.roominlist[roomid="'+roomid+'"] .description').html();
					description = $('#editroom_description').val();
					// console.log(description);
					$.ajax({
						method: "POST",
						url: "/rooms/"+roomid+"/listen",
						data: {"description":description},
					})
					.done(function(result) {
						if (result) {
							var audioElement = document.createElement('audio');
					    audioElement.setAttribute('src', '/storage/audio/'+result);
							audioElement.play();
						}
					})
				});

				$("#areagrid").draggable();

				$('.navbar').css('z-index','100')
				// $('.navbar').css('background-color','white')

				$('#allcontainers').css('z-index','100')
				// $('#allcontainers').css('background-color','white')

				// $('#areagrid').css('background-color','white')

			    initGrid();

			    registerGridEvents();

			    $('.campaigncheckbox').click(function(){
			    	areaid = $(this).attr('areaid');
			    	campaignid = $(this).attr('campaignid');
			    	// if ($(this).attr('ischecked') == 'false') {
			    		// ajax assign it!


			    		$.ajax({
			    			method: "POST",
			    			url: "/areas/"+areaid+"/campaigns/"+campaignid,
			    		})
		    			.done(function(result) {
		    				//console.log(result);
		    			})
			    		// when the ajax is done, check it
			    		// $(this).prop( "checked" );
			    	// }
			    })

			    $('.deleteroomentity').click(function(e){
			    	e.preventDefault();
			    	e.stopPropagation();
			    	thecloseicon = this;
			    	deleteRoomEntity(thecloseicon);
			    })

			    $('.deleteenvironment').click(function(e){
			    	e.preventDefault();
			    	e.stopPropagation();
			    	thecloseicon = this;
			    	deleteEnvironment(thecloseicon);
			    })


			    // $('.deletedoor').click(function(e){
			    // 	deletedoor(this);
			    // })

			    dragclick = 0;
			    $('#dragicon').click(function(){
			    	clearPanelIcons();
			    	$('body').css( 'cursor', 'drag' );
			    	$('#dragicon').css('color','green');
			    	$('#dragicon').attr('selected','true');
			    	$("#areagrid").draggable('enable');
			    	dragclick = 1;
			    });

			    environmentclick = 0;
			    $('#environmenticon').click(function(){
			    	// alert('Attention: The Environment function doesnt currently save to database; this is a brand new feature still in development!');
			    	// if (!doorclick) {
			    		clearPanelIcons();
			    		$('body').css( 'cursor', 'crosshair' );
			    		$('#environmenticon').css('background-color','green');
			    		$('#environmenticon').attr('selected','true');
			    		environmentclick = 1;
			    })

			    roomclick = 0;
			    $('#roomicon').click(function(){
			    	// if (!doorclick) {
			    		clearPanelIcons();
			    		$('body').css( 'cursor', 'crosshair' );
			    		$('#roomicon').css('background-color','green');
			    		$('#roomicon').attr('selected','true');
			    		roomclick = 1;
			    })


			    doorclick = 0;
			    $('#dooricon').click(function(){
			    	// if (!doorclick) {
			    		clearPanelIcons();
			    		$('body').css( 'cursor', 'crosshair' );
			    		$('#dooricon').css('background-color','green');
			    		$('#dooricon').attr('selected','true');
			    		doorclick = 1;
			    })

			    entityclick = 0;
			    $('#entityicon').click(function(){
			    	// if (!entityclick) {
			    		clearPanelIcons();
			    		$('body').css( 'cursor', 'crosshair' );
			    		$('#entityicon').css('background-color','green');
			    		$('#entityicon').attr('selected','true');
			    		entityclick = 1;
			    })

			    $('#editroomdialog form').submit(function(e){
			    	e.preventDefault();
			    	var formData = $('#editroomdialog form').serialize();
			    	$.ajax({
    					type: 'POST',
    					dataType: 'json',
    					url: $('#editroomdialog form').attr('action'),
    					data: formData
					})
					.done(function(result) {
						if (result != 0) {
							console.log(result);
							$('.roominlist[roomid="'+result.id+'"]').attr('name',result.name);
							$('.roominlist[roomid="'+result.id+'"]').attr('name',result.name);
							$('.roominlist[roomid="'+result.id+'"]').find('.roomname').html(' '+result.name+' ');
							$('.roominlist[roomid="'+result.id+'"]').attr('colour',result.colour);
							$('.room_'+result.id).css('background-color','#'+result.colour);
							$('.roominlist[roomid="'+result.id+'"] .description').html(result.description);
							$('#editroomdialog').dialog('close');
						}
					});
			    });

			    $('#createentitydialog form').submit(function(e){
			    	e.preventDefault();
			    	var formData = $('#createentitydialog form').serialize();
			    	$.ajax({
    					type: 'POST',
    					dataType: 'json',
    					url: $('#createentitydialog form').attr('action'),
    					data: formData
					})
					.done(function(result) {
						//console.log(result);

						if (result.success == 'true') {
							$('.highlighted').addClass('entity_'+result.entityid);
							$('.highlighted').addClass('roomentity_'+result.roomentityid);
							$('.highlighted').attr('entityid',result.entityid);
							$('.highlighted').attr('roomentityid',result.roomentityid);
							// $('.highlighted').css('background-color','#'+$('#entity_colour').val());
							// $('.highlighted').css('opacity','1');

							startcell = {}
				    		endcell = {}

				    		startcell.row = $('#entity_start_row').val()
				    		startcell.col = $('#entity_start_col').val()
				    		endcell.row = $('#entity_end_row').val()
				    		endcell.col = $('#entity_end_col').val()

				    		colour = $('#entity_colour').val()
				    		radius = $('#entity_cornerradius').val()
				    		roomentityid = result.roomentityid;

				    		roomid = $('#entity_room_id').val();

				    		roomname = $('.roominlist[roomid="'+roomid+'"]').attr('name');

							drawObject(startcell,endcell,colour,radius,roomentityid);

							$('.objectlist').append('<li class="objectinlist" name="'+$('#entity_name').val()+'" roomentityid="'+roomentityid+'" startrow="'+startcell.row+'" startcol="'+startcell.col+'" endrow="'+endcell.row+'" endcol="'+endcell.col+'" colour="#'+colour+'" radius="'+radius+'"><button class="btn btn-primary">'+result.entityname+' ('+roomname+') <span class="deleteroomentity" roomid="'+roomid+'" roomentityid="'+roomentityid+'"><i class="fas fa-times"></i></span></button></li>');

							// now we need to apply the hover and delete listeners to the object...
						    $('.objectinlist[roomentityid="'+roomentityid+'"]').mouseover(function(){
					    		// $('.roomentity_'+roomentityid).css('opacity',0.5);
					    		$('.object[roomentityid="'+roomentityid+'"').css('opacity',0.5);
						    })
						    $('.objectinlist[roomentityid="'+roomentityid+'"]').mouseout(function(){
					    		// $('.roomentity_'+roomentityid).css('opacity',1);
					    		$('.object[roomentityid="'+roomentityid+'"').css('opacity',1);
						    })

						    $('.objectinlist[roomentityid="'+roomentityid+'"] .deleteroomentity').click(function(e){
			    				e.preventDefault();
			    				e.stopPropagation();
			    				deleteRoomEntity(this);
			    				// $('.objectinlist[roomentityid="'+roomentityid+'"]').remove();
			    			})

							// add entity class to highlighted cells
							// set colour, radius to class
							// add entity in toolbar, add roomentity in Area Objects section (with entityname{roomentityid})
							$('.highlighted').removeClass('highlighted');
							$('#createentitydialog').dialog( "close" );
						}

					})
			    })

			    panelhidden = true;
				$('#toggleareapanels button').click(function(){
					if (panelhidden == false) {
						$('.minorpanel').fadeOut();
						$('#toggleareapanels button').html('Show Panels')
						panelhidden = true;
					}
					else {
						$('.minorpanel').fadeIn();
						panelhidden = false;
						$('#toggleareapanels button').html('Hide Panels')
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

				$('#createroomform').submit(function(e){
					e.preventDefault();
			    	var formData = $('#createroomform').serialize();
			    	console.log(formData);
			    	$.ajax({
    					type: 'POST',
    					dataType: 'json',
    					url: $('#createroomform').attr('action'),
    					data: formData
					})
					.done(function(result) {
						console.log(result);
						console.log('yay! now lets add classes to .highlighted class and add all the event listeners');
						if (result != 0) {
							colour = '';
							if (result.colour) {
								colour = result.colour;
							}

							theroombutton = "<li class='roominlist' name='"+result.name+"'\
							 roomid='"+result.id+"'\
							 startrow='"+result.start_row+"'\
							 startcol='"+result.start_col+"'\
							 endrow='"+result.end_row+"'\
							 endcol='"+result.end_col+"'\
							 colour='"+colour+"'>\
							 <span style='display:none' class='description'>"+result.description+"</span>\
								 <button class='btn btn-primary'>\
								 	<span class='editroom' roomid='"+result.id+"'>\
								 		<i class='fas fa-edit'></i>\
								 	</span>\
								 	<span class='roomname'>"+result.name+"</span>\
								 	<span class='deleteroom' roomid='"+result.id+"'>\
								 		<i class='fas fa-times'></i>\
								 	</span>\
								 </button>\
							 </li>";

							$('.roomlist').append(theroombutton);
							// draw room first
							drawRoom($('.roominlist[roomid="'+result.id+'"]')[0]);

							// now we add the listeners for the button events...

							$('#createroomdialog').dialog('close');

							$('#dragicon').click();
							// need to add listeners for:
							// edit, delete, click and hover
						}
					});

					console.log('here!');
				})
			});

			$('#createdoorform').submit(function(e){
				e.preventDefault();
		    	var formData = $('#createdoorform').serialize();
		    	console.log(formData);
		    	$.ajax({
					type: 'POST',
					dataType: 'json',
					url: $('#createdoorform').attr('action'),
					data: formData
				})
				.done(function(result) {
					console.log(result);
					console.log('yay! now lets add classes to .highlighted class and add all the event listeners');
					if (result != 0) {

						thedoorbutton = "<li class='doorinlist' name='door_"+result.id+"'\
						 doorid='"+result.id+"'\
						 startrow='"+result.start_row+"'\
						 startcol='"+result.start_col+"'\
						 endrow='"+result.end_row+"'\
						 endcol='"+result.end_col+"'\
						 locked='"+result.locked+"'\
						 ishidden='"+result.ishidden+"'\
						 difficulty='"+result.difficulty+"'\
						 placement='"+result.placement+"'>\
							 <button class='btn btn-primary'>\
							 	<span class='doorname'>Door"+result.id+"</span>\
							 	<span class='deletedoor' doorid='"+result.id+"'>\
							 		<i class='fas fa-times'></i>\
							 	</span>\
							 </button>\
						 </li>";

						$('.doorlist').append(thedoorbutton);
						// draw room first
						drawDoor($('.doorinlist[doorid="'+result.id+'"]')[0]);
						//drawDoor(startcell,endcell,hidden,locked,placement,false,doorid);
						// now we add the listeners for the button events...

						$('#createdoordialog').dialog('close');

						$('#dragicon').click();
						// need to add listeners for:
						// edit, delete, click and hover
					}
				});

				console.log('here!');
			});

			var isMouseDown = false;
			var isHighlighted;

			var startCell;
			var currentCell;

			function hashCode(str) { // java String#hashCode
			    var hash = 0;
			    if (str) {
				    for (var i = 0; i < str.length; i++) {
				       hash = str.charCodeAt(i) + ((hash << 5) - hash);
				    }
				}
				else {
					hash = "00000";
				}
			    return hash;
			}

			function intToRGB(i){
			    var c = (i & 0x00FFFFFF)
			        .toString(16)
			        .toUpperCase();

			    return "00000".substring(0, 6 - c.length) + c;
			}

			function deleteRoomEntity(thecloseicon) {

		    	roomentityid = $(thecloseicon).attr('roomentityid');
		    	roomid = $(thecloseicon).attr('roomid');
	    		$.ajax({
	    			method: "DELETE",
	    			url: "/roomentities/"+roomentityid,
	    		})
    			.done(function(result) {
    				// console.log(result);
    				if (result) {
    					// $('.roomentity_'+roomentityid).removeClass('highlighted');
    					// // we need to set the background colour to the room background colour... for that we will need the roomID and the room name
    					// // console.log('heres the roomentity id: '+roomentityid);
    					// roomname = $('.roominlist[roomid="'+roomid+'"]').attr('name');
    					// // console.log('heres the roomid: '+roomid);
    					// // console.log('heres the roomname: '+roomname);

    					// randColor = intToRGB(hashCode(roomname));
    					// $('.roomentity_'+roomentityid).css('background-color','#'+randColor);
    					// $('.roomentity_'+roomentityid).css('opacity','0.5');
    					// $('.roomentity_'+roomentityid).css('border-radius','0px');
    					// $('.roomentity_'+roomentityid).removeClass('roomentity_'+roomentityid);

    					// $(thecloseicon).parent().remove();

    					location.reload();
    				}
    			})
			}

			function deleteEnvironment(thecloseicon) {
		    	environmentid = $(thecloseicon).attr('environmentid');
	    		$.ajax({
	    			method: "DELETE",
	    			url: "/environments/"+environmentid,
	    			dataType: 'json'
	    		})
    			.done(function(result) {
    				if (result.success) {
    					location.reload();
    				}
    				else {
    					alert('Error a '+result.error+' is currently in the Area! Move/Unassign it first in Campaign View!');
    				}
    			})
			}

			function clearPanelIcons() {
				$('.roominlist button').removeClass('btn-danger active');
				$('.roominlist button').addClass('btn-primary');

				$('.roomiconname').remove();
				$('.actionpanelicons li').removeAttr('selected');
			    $('.actionpanelicons li').css('background-color','transparent');
		    	$("#areagrid").draggable('disable');

		    	$('#dragicon').css('color','black');

			    doorclick = 0;
			    entityclick = 0;
			    environmentclick = 0;
			    roomclick = 0;
			    dragclick = 0;
			}

			function initGrid() {
			    buildTable({{$area->max_width}},{{$area->max_height}});
			    // need to do this when an area is created



			    // once built, we set the rooms
			    if ($('.roomlist').html()) {
			    	// console.log('has rooms');
			    	$('.roominlist').each(function() {
			    		drawRoom(this);
			    	})
			    }

			    if ($('.environmentlist').html()) {
			    	// console.log('has rooms');
			    	$('.environmentinlist').each(function() {

			    		// we need to get ajax data for each environment to get the rows...

			    		environmentid = $(this).attr('environmentid');

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




			    		// highlightCells(startcell,endcell,false,randColor,roomid);
			    		// ok now we draw it...
			    	})
			    }


			    if ($('.doorlist').html()) {
			    	//console.log('has doors');
			    	$('.doorinlist').each(function() {
			    		drawDoor(this);
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


			    $('.doorinlist').mouseover(function(){
			    	doorid = $(this).attr('doorid');
		    		$('.door_'+doorid).css('opacity',1);
			    })

			    $('.doorinlist').mouseout(function(){
			    	doorid = $(this).attr('doorid');
		    		$('.door_'+doorid).css('opacity',0.5);
			    })

			    $('.objectinlist').mouseover(function(){
			    	roomentityid = $(this).attr('roomentityid');
		    		// $('.roomentity_'+roomentityid).css('opacity',0.5);
		    		$('.object[roomentityid="'+roomentityid+'"').css('opacity',0.5);
			    })

			    $('.objectinlist').mouseout(function(){
			    	roomentityid = $(this).attr('roomentityid');
		    		// $('.roomentity_'+roomentityid).css('opacity',1);
		    		$('.object[roomentityid="'+roomentityid+'"').css('opacity',1);
			    })


			}

			$('#createarea').click(function(){
			  $( "#createareadialog" ).dialog();
			})

			// width = parseFloat($('.actualroom').css('width'));
			// height = parseFloat($('.actualroom').css('height'));



			$('#areagrid').mousewheel(function(turn, delta) {
				// console.log(width);
				// console.log(height);
				turn.preventDefault();

				if (delta == 1) {
					//Scrolling Down
					//console.log('down?');
					//Scrolling Up
					if (width < 16 && height < 16) {
						width = width + 1;
						height = height + 1;
						$('#areagrid td').css('width',width+'px');
						$('#areagrid td').css('height',height+'px');
					}

				}
				else {
					//console.log('up?');

						width = width - 1;
						height = height - 1;
						//console.log('old: '+width+' '+height);
						//console.log('new: '+width+' '+height);
						$('#areagrid td').css('width',width+'px');
						$('#areagrid td').css('height',height+'px');

				}
			});




			function registerGridEvents() {

				// $('#areagrid td').bind('touchstart', function() {});

				// touchstarted = false;
				// $("#areagrid td").on('touchstart',function(e){
				// 	//console.log('starttouching!');
				// });

				// $("#areagrid td").on('touchmove',function(e){
				// 	//console.log('touchmoving!');
				// });

				// $("#areagrid td").on('touchend',function(e){
				// 	//console.log('touchending!');
				// });

				// remove all
				$("#areagrid td").off();

			    $("#areagrid td").on('mousedown', function (e) {
			    	thecell = this;
			        if ($('#dooricon').attr('selected') == 'selected' || $('#entityicon').attr('selected') == 'selected')  {
			        	isMouseDown = true;
			       		startCell = getCellPosition($(this));
			       		$('#currentroom').attr('fromr',startCell.row);
			    		$('#currentroom').attr('fromc',startCell.col);
			    		$('#currentroom').attr('tor',startCell.row);
			    		$('#currentroom').attr('toc',startCell.col);
			        	highlightCells(startCell, startCell,'','black');
			        }
			        else if ($('#environmenticon').attr('selected') == 'selected') {
			        	isMouseDown = true;
			       		startCell = getCellPosition($(this));
			       		$('#currentroom').attr('fromr',startCell.row);
			    		$('#currentroom').attr('fromc',startCell.col);
			    		$('#currentroom').attr('tor',startCell.row);
			    		$('#currentroom').attr('toc',startCell.col);
			        	highlightCell(startCell);
			        	// drawEnvironment();
			        }
			        else if ($('#roomicon').attr('selected') == 'selected'){
			        	startCell = getCellPosition($(this));
			        	roomextension = 0;
			        	error = false;
		    			if ($(thecell).hasClass('room')) {
		    				alert('Cant create a room inside a room');
		    				error = true;
		    			}

		    			if ($('.roomiconname').attr('roomid')) {
		    				// a room has been selected
			    			// check to make sure there is an adjacent square the same as the id of the room selected

		    				roomid = $('.roomiconname').attr('roomid');
		    				noadjacentcy = true;


		    				// is the cell to the right the same room?
		    				rightcol = startCell.col + 1;
		    				// console.log('here: '+startCell.col+' '+startCell.row);
		    				if ($('td[data-row="'+startCell.row+'"][data-col="'+rightcol+'"]').attr('roomid')) {
		    					if ($('td[data-row="'+startCell.row+'"][data-col="'+rightcol+'"]').attr('roomid') == roomid) {
		    						noadjacentcy = false;
		    					}
		    				}


		    				// is the cell to the left the same room?
		    				leftcol = startCell.col - 1;
		    				if ($('td[data-row="'+startCell.row+'"][data-col="'+leftcol+'"]').attr('roomid')) {
		    					if ($('td[data-row="'+startCell.row+'"][data-col="'+leftcol+'"]').attr('roomid') == roomid) {
		    						noadjacentcy = false;
		    					}
		    				}


							// is the cell above the same room?
		    				toprow = startCell.row - 1;
		    				if ($('td[data-row="'+toprow+'"][data-col="'+startCell.col+'"]').attr('roomid')) {
		    					if ($('td[data-row="'+toprow+'"][data-col="'+startCell.col+'"]').attr('roomid') == roomid) {
		    						noadjacentcy = false;
		    					}
		    				}

							// is the cell below the same room?
		    				bottomrow = startCell.row + 1;
		    				if ($('td[data-row="'+bottomrow+'"][data-col="'+startCell.col+'"]').attr('roomid')) {
		    					if ($('td[data-row="'+bottomrow+'"][data-col="'+startCell.col+'"]').attr('roomid') == roomid) {
		    						noadjacentcy = false;
		    					}
		    				}

		    				if (noadjacentcy == false) {
								roomextension = roomid;
		    				}
		    				else {
		    					alert('Room Extensions must be next to the room being extended');
		    					error = true;
		    				}
			    		}

			    		if (error == false) {
				        	isMouseDown = true;
				       		$('#currentroom').attr('fromr',startCell.row);
				    		$('#currentroom').attr('fromc',startCell.col);
				    		$('#currentroom').attr('tor',startCell.row);
				    		$('#currentroom').attr('toc',startCell.col);

				    		if (roomextension > 0) {
				    			highlightCells(startCell,startCell,false,'',roomid);
				    		}
				    		else {
			        			highlightCells(startCell, startCell);
			        		}
			        	}
			        }
			        else {

			        }
					// isMouseDown = true;
					// startCell = getCellPosition($(this));
			  //       console.log('is mouse down?')
			        // return false; // prevent text selection

			    }).on('mouseover', function (e) {
			        if (isMouseDown && startCell) {
				        currentCell = getCellPosition($(this));

				        if ($('#dooricon').attr('selected') == 'selected' || $('#entityicon').attr('selected') == 'selected')  {
				        	// it is door
				        	if ($('#dooricon').attr('selected') == 'selected') {
				        		highlightCells(startCell, currentCell,'','black','',true);
				        	}
				        	else {
				        		highlightCells(startCell, currentCell,'','black');
				        	}
				        }
				        else if ($('#environmenticon').attr('selected') == 'selected') {
				        	highlightCell(currentCell);
				        	// drawEnvironment();
				        }
				        else if ($('#roomicon').attr('selected') == 'selected'){
				        	highlightCells(startCell, currentCell);
				        }
				        else {

				        }
			            //$(this).toggleClass("highlighted", isHighlighted);
			        }
			    }).on('mouseup',function(e){
					fromr = $('#currentroom').attr('fromr');
					fromc = $('#currentroom').attr('fromc');
					tor = $('#currentroom').attr('tor');
					toc = $('#currentroom').attr('toc');
					roomid = $(this).attr('roomid');
					wall = $(this).attr('wall');

					startcell = {}
		    		endcell = {}

		    		startcell.row = fromr;
		    		startcell.col = fromc;
		    		endcell.row = tor;
		    		endcell.col = toc;

			    	if ($('#dooricon').attr('selected') == 'selected') {
			    		if (roomid && wall && fromr) {
							$('#currentroom').attr('fromr','');
							$('#currentroom').attr('fromc','');
							$('#currentroom').attr('tor','');
							$('#currentroom').attr('toc','');
							// we get the current cell coords, then will trigger requester asking what direction the door is in...
							// console.log('here '+tor+' '+toc);
							$('#door_start_row').val(fromr);
							$('#door_start_col').val(fromc);
							$('#door_end_row').val(tor);
							$('#door_end_col').val(toc);
							// should probably assign the door to a room...
							$('#door_room_id').val(roomid);

							$('#placement').val(wall);

							$( "#createdoordialog" ).dialog().on('dialogclose', function(event) {
								highlightCells(startCell, currentCell);
							});

							$('#dooricon').click();
						}
						else {
							alert('Door Must be created on a wall!');
							highlightCells(startCell, currentCell);
							clearHighlight();
						}
			    	}
			    	else if ($('#entityicon').attr('selected') == 'selected') {
			    		if (roomid) {
			    			$('#entity_name').val('');
					      	$('#entity_top_left').css('border-radius','0px 0px 0px 0px');
					      	$('#entity_top_right').css('border-radius','0px 0px 0px 0px');
					      	$('#entity_bottom_right').css('border-radius','0px 0px 0x 0px');
					      	$('#entity_bottom_left').css('border-radius','0px 0px 0px 0px');
					      	$('#entity_room_id').val('');

							$('#entity_cornerradius').val('');
							$('#entity_colour').val('000000');
							$('#entity_colour').ColorPicker({
								onSubmit: function(hsb, hex, rgb, el) {
									$(el).val(hex);
									$(el).ColorPickerHide();
									$('.entity_preview').css('background-color','#'+hex);
								},
								onBeforeShow: function () {
									$(this).ColorPickerSetColor(this.value);
								}
							})
							.bind('keyup', function(){
								$(this).ColorPickerSetColor(this.value);
								$('.entity_preview').css('background-color','#'+this.value);
							});

							$('#currentroom').attr('fromr','');
							$('#currentroom').attr('fromc','');
							$('#currentroom').attr('tor','');
							$('#currentroom').attr('toc','');
							// we get the current cell coords, then will trigger requester asking what direction the door is in...
							// console.log('here '+tor+' '+toc);

							// setting the field values for the dialog box...
							$('#entity_start_row').val(fromr);
							$('#entity_start_col').val(fromc);
							$('#entity_end_row').val(tor);
							$('#entity_end_col').val(toc);
							$('#entity_room_id').val(roomid);


							height = (tor - fromr);
							width = (toc - fromc);

							$('#entity_height').val(height);
							$('#entity_width').val(width);

							//console.log('height '+height+' width'+width);

							// $('#objectpreview').html('<table>')

							tabledata = '<table>';

							for (h = 0; h < height; h++) {
								firstrow = false;
								lastrow = false;
								if (h == 0) {
									firstrow = true;
								} else if (h == height) {
									lastrow = true;
								}
    							else {
    								tabledata = tabledata + '<tr>';
    							}

    								for (w = 0; w < width; w++) {

    									if (w == 0) {
    										if (firstrow) {
    											tabledata = tabledata + '<td class="entity_preview_corner entity_preview" corner="top-left" id="entity_top_left"></td>';
    										}
    										else if (lastrow) {
    											tabledata = tabledata + '<td class="entity_preview_corner entity_preview" corner="bottom-left" id="entity_bottom_left"></td>';
    										}
    										else {
    											tabledata = tabledata + '<td class="entity_preview"></td>';
    										}
    									}
    									else if (w == width) {
    										if (firstrow) {
    											tabledata = tabledata + '<td class="entity_preview_corner entity_preview" corner="top_right" id="entity_top_right"></td>';
    										}
    										else if (lastrow) {
    											tabledata = tabledata + '<td class="entity_preview_corner entity_preview" corner="bottom-right" id="entity_bottom_right"></td>';
    										} else {
    											tabledata = tabledata + '<td class="entity_preview"></td>';
    										}

    									}
    									else {
    										tabledata = tabledata + '<td class="entity_preview"></td>';
    									}
    								}
    							tabledata = tabledata + '</tr>';
							}

							tabledata = tabledata + '</table>';

							//console.log('data:'+tabledata)
							$('#objectpreview').html(tabledata);

					      $("#createentitydialog" ).dialog().on('dialogclose', function(event) {
								highlightCells(startCell, currentCell);
							});

					      $('#entityicon').click();

					      $('#entity_cornerradius').keyup(function(){
					      	radius = $('#entity_cornerradius').val();
					      	$('#entity_top_left').css('border-radius',radius+'% 0px 0px 0px');
					      	$('#entity_top_right').css('border-radius','0px '+radius+'% 0px 0px');
					      	$('#entity_bottom_right').css('border-radius','0px 0px '+radius+'% 0px');
					      	$('#entity_bottom_left').css('border-radius','0px 0px 0px '+radius+'%');
					      	//console.log(radius);
					      })

					      // we need to work out the width (cols) and height (rows) of the object from the start and end
					      // then we get the col and row coords for the top right position, according to the current room (will need to take the roomid)

					      // we will create an object with the width and height, then attach the object to the room, with the offset
					    } else {
					    	alert('Object must be created inside an Existing room!');
					    	highlightCells(startCell, currentCell);
					    	clearHighlight();
					    }
			    	}
			    	else if ($('#roomicon').attr('selected') == 'selected') {
			    		if (roomid) {
			    			alert('Cant create a room inside a room');
					    	highlightCells(startCell, currentCell);
					    	clearHighlight();
			    		}
						else if (fromr && fromc && tor && toc) {
							$('#currentroom').attr('fromr','');
							$('#currentroom').attr('fromc','');
							$('#currentroom').attr('tor','');
							$('#currentroom').attr('toc','');

							// randColor = intToRGB(hashCode($(this).attr('name')));

							//$('#room_colour').val('000000');
							$('#room_colour').ColorPicker({
								onSubmit: function(hsb, hex, rgb, el) {
									$(el).val(hex);
									$(el).ColorPickerHide();
									// $('.entity_preview').css('background-color','#'+hex);
								},
								onBeforeShow: function () {
									$(this).ColorPickerSetColor(this.value);
								}
							})
							.bind('keyup', function(){
								$(this).ColorPickerSetColor(this.value);
								// $('.entity_preview').css('background-color','#'+this.value);
							});

							// ok we clear it first, then save room. but will need to ask the room name
							$('#start_row').val(fromr);
							$('#start_col').val(fromc);
							$('#end_row').val(tor);
							$('#end_col').val(toc);

							if ($('.roomiconname').attr('roomid')) {
								// console.log('hereomg?');
								// its a room extension! so ajax add it! then probably reload!
								roomid = $('.roomiconname').attr('roomid');
								$.ajax({
					    			method: "POST",
					    			url: "/extensions",
					    			dataType: 'json',
					    			data: {"area_id":{{$area->id}},"room_id":roomid,"start_row":fromr,"start_col":fromc,"end_row":tor,"end_col":toc},
					    		})
				    			.done(function(result) {
				    				// console.log(result);
				    				if (result) {
				    					location.reload();
				    				}
				    				//
				    			})
							}
							else {
								$( "#createroomdialog" ).dialog().on('dialogclose', function(event) {
									//console.log('here?');
								 	clearHighlight()
								});
							}
						}
			    	}
			    	else if ($('#environmenticon').attr('selected') == 'selected') {
			    		if (fromr && fromc && tor && toc) {
			    			// if tocell is next to fromcell...
			    			//console.log('fromr: '+fromr,'fromc: '+fromc,' tor: '+tor,' toc: '+toc);
			    			if (fromr == tor && fromc == toc && $('.highlighted')[5]) {
			    				// the start cell is the current cell AND there are more than one highlighted cells...
			    				envrows = fillEnvironment();

								$('#environment_colour').val('000000');
								$('#environment_colour').ColorPicker({
									onSubmit: function(hsb, hex, rgb, el) {
										$(el).val(hex);
										$(el).ColorPickerHide();
									},
									onBeforeShow: function () {
										$(this).ColorPickerSetColor(this.value);
									}
								})

								$('#environment_rows').val(JSON.stringify(envrows));

								$( "#createenvironmentdialog" ).dialog().on('dialogclose', function(event) {
									//console.log('here?');
								 	clearHighlight()
								});

			    			}
			    			else {
			    				alert('When drawing an environment, the last cell must be the same as the beginning AND there should be more than 4 cells selected.')
			    				// clear highlighted
			    				clearHighlight()
			    			}
			    		}
			    	}
			    });

			    $(document)
			        .mouseup(function () {
			        isMouseDown = false;
			    });

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
						if ($('td[data-row="'+r+'"][data-col="'+c+'"]').hasClass('room')) {

						}
						else {
							$('td[data-row="'+r+'"][data-col="'+c+'"]').css('background-color','#'+colour);
							// $('td[data-row="'+r+'"][data-col="'+c+'"]').css('opacity','0.5');
						}

					}
				});
			}

			function fillEnvironment() {
				// first, we go through each highlighted cell..
				// foreach that have the same row... we highlight each cell that is between the lowest and highest col of that row...

				// we need to pass an array of rows that have a start and end cols
				rows = [];

				for (r = 0; r < maxheight; r++) {
					if ($('.highlighted[data-row="'+r+'"]')[0]) {
						//console.log($('.highlighted[data-row="'+r+'"]')[0])

						// if there is a highlighted cell on the iterating row...
						firstcol = 0;
						hasfirst = false;
						lastcol = maxwidth;
						togglefill = false;
						for (c = 0; c < lastcol; c++) {

							if ($('.highlighted[data-row="'+r+'"][data-col="'+c+'"]')[0]) {
								// console.log('here?');
								if (hasfirst == false) {
									// console.log('is it false?');
									// because we're iterating in order, the first one will be the first in the row
									hasfirst = true;
									firstcol = c;

									// we know what the firest col of the row is, that is highlighted... so on this row, lets find the last col...
									// the last element of this:
									lastcellofrow =$('.highlighted[data-row="'+r+'"]').last();
									// now set the lastcol
									lastcol = $(lastcellofrow).attr('data-col');
								}
							}

							if (hasfirst == true) {
								//console.log('it should be highlighting.')
								// we have registered the first cell of the row being highlighted...
								// keep highlighting every cell until we get to the last highlighted...

								$('td[data-row="'+r+'"][data-col="'+c+'"]').addClass('highlighted');
								// $('td[data-row="'+r+'"][data-col="'+c+'"]').css('opacity','0.5');

							}
						}

						if (firstcol >= 0 && lastcol < maxwidth) {
							rowobject = {row:r,fromcol:firstcol,tocol:lastcol};
							rows[r] = rowobject;
						}
					}
				}

				// console.log(rows);
				return rows;

				// we then ajax save a new environment... which will save an EnvironmentRow (id,environment_id,row,startcol,endcol)
			}

			function drawRoom(theroombutton) {
				console.log('drawing room...');
				console.log(theroombutton);
				startcell = {}
	    		endcell = {}

	    		startcell.row = $(theroombutton).attr('startrow');
	    		startcell.col = $(theroombutton).attr('startcol')
	    		endcell.row = $(theroombutton).attr('endrow')
	    		endcell.col = $(theroombutton).attr('endcol')

	    		roomid = $(theroombutton).attr('roomid');

	    		// random colour?
	    		// var randomColor = Math.floor(Math.random()*16777215).toString(16);
	    		if ($(theroombutton).attr('colour')) {
	    			// console.log('this is the colour: '+$(this).attr('colour'))
	    			randColor = $(theroombutton).attr('colour');
	    		}
	    		else {
	    			randColor = intToRGB(hashCode($(theroombutton).attr('name')));
	    			console.log('this is randcolor '+randColor);
	    		}
	    		// console.log('this is colouromg: '+randColor);
	    		highlightCells(startcell,endcell,false,randColor,roomid);
	    		clearHighlight();
	    		// ok now we draw it...

	    		$(theroombutton).find('.roomextensioninlist').each(function(){
		    		startcell = {}
		    		endcell = {}

		    		startcell.row = $(this).attr('startrow');
		    		startcell.col = $(this).attr('startcol')
		    		endcell.row = $(this).attr('endrow')
		    		endcell.col = $(this).attr('endcol')
		    		highlightCells(startcell,endcell,false,randColor,roomid);
	    			clearHighlight();
	    		})

	    		roomid = $(theroombutton).attr('roomid');

	    		$(theroombutton).mouseover(function(){
		    		roomid = $(theroombutton).attr('roomid');
		    		$('.room_'+roomid).css('opacity',0.5);
			    })


			    $(theroombutton).mouseout(function(){
			    	roomid = $(theroombutton).attr('roomid');
		    		$('.room_'+roomid).css('opacity',1);
			    })

			    $(theroombutton).find('button').click(function(){
			    	roomid = $(this).parent().attr('roomid');
			    	roomname = $(this).parent().attr('name');
			    	if ($(this).hasClass('active')) {
			    		$('#dragicon').click();
			    		$(this).removeClass('active');
			    		$(this).removeClass('btn-danger');
			    		$(this).addClass('btn-primary');
			    		$('#roomicon span').remove();
			    	}
			    	else {
						$('.roomiconname').remove();
				    	$('#roomicon').click();
				    	$('#roomicon').append('<div class="roomiconname" roomid="'+roomid+'">[ '+roomname+' ]</div>')
				    	$('.roominlist button').removeClass('btn-danger');
				    	$('.roominlist button').addClass('btn-primary');
				    	$('.roominlist button').removeClass('active');
				    	$(this).removeClass('btn-primary');
				    	$(this).addClass('btn-danger');
				    	$(this).addClass('active');
				    }
			    })

			    $(theroombutton).find('.editroom').click(function(e){
			    	e.preventDefault();
		    		e.stopPropagation();
			    	editroom(this);
			    });

			    $(theroombutton).find('.deleteroom').click(function(e){
			    	e.preventDefault();
		    		e.stopPropagation();
			    	deleteroom(this);
			    });

			}

			function highlightCell(currentcell,environmentid='') {
				// console.log('currentcell');
				// console.log(currentcell);
				selectedRow = currentcell.row;
				selectedCol = currentcell.col;
				$('td[data-row="' + selectedRow + '"][data-col="' + selectedCol + '"]').addClass('highlighted');
				$('td[data-row="' + selectedRow + '"][data-col="' + selectedCol + '"]').css('opacity','0.8');
				$('#currentroom').attr('tor',selectedRow);
			    $('#currentroom').attr('toc',selectedCol);
				if (environmentid) {
					$('td[data-row="' + selectedRow + '"][data-col="' + selectedCol + '"]').addClass('environment_'+environmentid);
				}

			    if (selectedCol >= maxwidth-1) {
			    	// if we have reached the end of the width of the area...
			    	// then we expand the width of the area by 1 cell..
			    	// will need to call a function...
			    	expandAreaWidth();
			    }

			    if (selectedRow >= maxheight-1) {
			    	expandAreaHeight();
			    }


			}

			function highlightCells(start, end, hover = false, colour= '', roomid='',isdoor = false) {

			    var fromRow = Math.min(start.row, end.row);
			    var toRow = Math.max(start.row, end.row);

			    var fromCol = Math.min(start.col, end.col);
			    var toCol = Math.max(start.col, end.col);


			    // console.log('fromRow ' + fromRow + ' fromCol ' + fromCol + ' ~~~ toRow ' + toRow + ' toCol ' + toCol + ' isdoor? ' +isdoor);

			    if (toCol >= maxwidth-1) {
			    	// if we have reached the end of the width of the area...
			    	// then we expand the width of the area by 1 cell..
			    	// will need to call a function...
			    	expandAreaWidth();
			    }

			    if (toRow >= maxheight-1) {
			    	expandAreaHeight();
			    }



			    doorerror = false;
			    if (isdoor) {
			    	if (fromRow != toRow) {
			    		//thats fine, as long as the toCol equals fromCol...
			    		if (fromCol != toCol) {
			    			// yeah we have a problem. it means the door isnt in one line, so lets not highlight
			    			doorerror = true;
			    				$('#currentroom').attr('fromr','');
				    			$('#currentroom').attr('fromc','');
				    			$('#currentroom').attr('tor','');
				    			$('#currentroom').attr('toc','');
				    			clearHighlight();
			    		}
			    	}
			    }

			    if (doorerror == false) {

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
				        	if (isdoor) {
				        		if ($('td[data-row="' + i + '"][data-col="' + j + '"]').hasClass('wall')) {
				        			$('td[data-row="' + i + '"][data-col="' + j + '"]').addClass('highlighted');
				            		$('td[data-row="' + i + '"][data-col="' + j + '"]').css('opacity','0.8');
				        		}
				        		else {
				        			$('td[data-row="' + i + '"][data-col="' + j + '"]').removeClass('highlighted');
				        			// $('td[data-row="' + i + '"][data-col="' + j + '"]').css('opacity','1');
				        		}
				        	}
				        	else {
				        		$('td[data-row="' + i + '"][data-col="' + j + '"]').addClass('highlighted');
				            	$('td[data-row="' + i + '"][data-col="' + j + '"]').css('opacity','0.8');
				        	}



				            if (hover) {
				            	$('td[data-row="' + i + '"][data-col="' + j + '"]').addClass('hovering');
				            	// $('.hovering').css('background-color','white');
				            	$('.hovering').css('opacity','1');
				            }

				            if (roomid) {
				            	$('td[data-row="' + i + '"][data-col="' + j + '"]').addClass('room_'+roomid);
				            	$('td[data-row="' + i + '"][data-col="' + j + '"]').addClass('room');
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
				            	// $('td[data-row="' + i + '"][data-col="' + j + '"]').css('opacity','0.1');
				            }
				        }

				    }
				}
			}

			function expandAreaWidth() {
				maxwidth++;
				$('#areagrid tr').each(function( index ) {
					realwidth = maxwidth - 1;
					$(this).append('<td data-row="'+index+'" data-col="'+realwidth+'" style="opacity: 0.5; width: '+width+'px; height: '+height+'px"></td>')
				});
				registerGridEvents()
			}

			function expandAreaHeight() {
				// console.log('get here??');

				newrow = "<tr>";

				for (i = 0; i <= maxwidth; i++) {
					// need to create the tr html

					newrow = newrow + '<td data-row="'+maxheight+'" data-col="'+i+'" style="opacity: 0.5; width: '+width+'px; height: '+height+'px"></td>';
				}
				newrow = newrow + '</tr>';
				$('#areagrid table').append(newrow);
				maxheight++;
				registerGridEvents()
			}

			function drawDoor(thedoor) {

				hover = false;

				start = {}
			    end = {}

	    		start.row = $(thedoor).attr('startrow');
	    		start.col = $(thedoor).attr('startcol')
	    		end.row = $(thedoor).attr('endrow')
	    		end.col = $(thedoor).attr('endcol')

	    		placement = $(thedoor).attr('placement');
	    		hidden = $(thedoor).attr('ishidden');
	    		locked = $(thedoor).attr('locked');
	    		difficulty = $(thedoor).attr('difficulty');
	    		doorid = $(thedoor).attr('doorid');

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

	    		doorid = $(thedoor).attr('doorid');

	    		$(thedoor).mouseover(function(){
		    		doorid = $(thedoor).attr('doorid');
		    		$('.door_'+doorid).css('opacity',0.5);
			    })


			    $(thedoor).mouseout(function(){
			    	doorid = $(thedoor).attr('doorid');
		    		$('.door_'+doorid).css('opacity',1);
			    })

			    $(thedoor).find('.deletedoor').click(function(e){
			    	e.preventDefault();
		    		e.stopPropagation();
			    	deletedoor(this);
			    });
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

			            //console.log('this is the roomentityid: '+roomentityid)
			            if (roomentityid) {
			            	//console.log('ookroomentity??');
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

			function clearHighlight() {
				// $('.highlighted:not(.room)').css('background-color','white');
				// $('.highlighted:not(.room)').css('opacity','1');
				$('td').css('opacity','1');
			    $('td').removeClass('hovering');
			    $('td').removeClass('highlighted');
			    $('td').removeClass('highlightedenvironment');
			    // $('td').css('border-radius','0px');

			}


			function getCellPosition($cell) {
			    var cell = {
			        row: $cell.data('row'),
			        col: $cell.data('col')
			    }
			    return cell;
			}

			function buildTable(areawidth,areaheight) {
			    var tableHtml = '';
			    tableHtml = '<table cellpadding="0" cellspacing="0" style="background-color:white; border:2px solid black">';
			    for (i = 0; i < areaheight; i++) {
			        tableHtml += '<tr>';
			        for (j = 0; j < areawidth; j++) {
			            tableHtml += '<td data-row="' + i + '" data-col="' + j + '" style="width: '+width+'px; height: '+height+'px"></td>';
			        }
			        tableHtml += '</tr>';
			    }
			    tableHtml += '</table>';
			    $('#areagrid').html(tableHtml);
			}

			var hexDigits = new Array
			        ("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f");

			//Function to convert rgb color to hex format
			function rgb2hex(rgb) {
			 rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
			 return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
			}

			function hex(x) {
			  return isNaN(x) ? "00" : hexDigits[(x - x % 16) / 16] + hexDigits[x % 16];
			 }

		 	function editroom(theroomicon) {
		    	roomid = $(this).attr('roomid');
		    	roomname =  $('.roominlist[roomid="'+roomid+'"]').attr('name');
		    	roomdescription = $('.roominlist[roomid="'+roomid+'"] .description').html();
		    	console.log('this is the name '+roomname);
		    	roomcolour = $('.room_'+roomid).css('background-color');
		    	console.log('this is the room colour: '+roomcolour);

					roomcolour = rgb2hex(roomcolour);

					$('#listentoroom').attr('roomid',roomid);

		    	$('#editroom_colour').val(roomcolour);
						$('#editroom_colour').ColorPicker({
							onSubmit: function(hsb, hex, rgb, el) {
								$(el).val(hex);
								$(el).ColorPickerHide();
								// $('.entity_preview').css('background-color','#'+hex);
							},
							onBeforeShow: function () {
								$(this).ColorPickerSetColor(this.value);
							}
						})
						.bind('keyup', function(){
							$(this).ColorPickerSetColor(this.value);
							// $('.entity_preview').css('background-color','#'+this.value);
						});

				$('#editroomdialog form').attr('action','/rooms/'+roomid);
				$('#editroomname').val(roomname);
				$('#editroom_description').val(roomdescription);
				$("#editroomdialog" ).dialog().on('dialogclose', function(event) {

				});
		    }

		    function deletedoor(thedooricon) {
		    		//console.log('deletedoor?');
			    	// e.preventDefault();
			    	// e.stopPropagation();
			    	doorid = $(this).attr('doorid');
			    	thedoorcloseicon = this;
		    		$.ajax({
		    			method: "DELETE",
		    			url: "/doors/"+doorid,
		    		})
	    			.done(function(result) {
	    				//console.log(result);
	    				if (result) {
	    					$('.door_'+doorid).removeClass('doorright doorleft doortop doorbottom doorhidden doorlocked door');
	    					$('.door_'+doorid).css('opacity','1');
	    					$('.door_'+doorid).removeClass('door_'+doorid);
	    					$('.doorinlist[doorid="'+doorid+'"]').remove();
	    				}
	    			})
		    }

		    function deleteroom(theroomicon) {
		    	//console.log('test');
		    	roomid = $(this).attr('roomid');
		    	theroomcloseicon = this;
	    		$.ajax({
	    			method: "DELETE",
	    			url: "/rooms/"+roomid,
	    			dataType: 'json'
	    		})
    			.done(function(result) {
    				//console.log(result);
    				//console.log(result.error);
    				if (result) {
    					if (result.success) {
	    					// $('.room_'+roomid).removeClass('highlighted');
	    					// $('.room_'+roomid).removeClass('room');
	    					// $('.room_'+roomid).css('background-color','transparent');
	    					// $('.room_'+roomid).css('opacity','0.5');
	    					// $('.room_'+roomid).removeAttr('roomid');
	    					// $('.room_'+roomid).css('background-color','');
	    					// $('.room_'+roomid).css('opacity','');
	    					// $('.room_'+roomid).removeClass('room_'+roomid);

	    					// $(theroomcloseicon).parent().remove();

	    					// With Environments being under the rooms, fuck it, reload the page
	    					// we'll just reload everytime something is deleted I think
	    					location.reload();
    					}
    					else {
    						switch(result.error) {
    							case 'character':
    								alert('ERROR: A Character is currently in the room! Unassign them in Campaign view before Deleting the Room!');
    								break;
    							case 'creature':
    								alert('ERROR: A Character is currently in the room! Unassign them in Campaign view before Deleting the Room!');
    								break;
    							case 'entity':
    								alert('ERROR: An Object is still in the room! Delete it before Deleting the Room');
    								break;
    						}
    					}
    				}
    			})
		    }

	</script>
@endsection
