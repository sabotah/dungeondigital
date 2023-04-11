@extends('layouts.admin')

@section('content')
	<div style="color:red; font-weight:bold;">** Touch Events on Mobile/Tablet are currently not supported when creating Areas - It does work in Campaign view though - So, Create Areas on Desktop, then play the Campaign on Tablet if needs be **</div>
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

	<ul class="arealist">
		<li><button class="btn-success btn clearfix" id="createarea">Create Area</button></li>
		@foreach ($areas as $thearea)
			<li><a href="/areas/{{$thearea->id}}"><button class="btn btn-primary">{{$thearea->name}}</button></a></li>
		@endforeach
	</ul>

@endsection

@section("scripts")
	<script>
		console.log('here?');
			$('#createarea').click(function(){
				console.log('here?');
			  $( "#createareadialog" ).dialog();
			})
	</script>
@endsection
