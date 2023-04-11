<form action="/campaigncreatures/{{$campaigncreature->id}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" aria-describedby="name" placeholder="{{$campaigncreature->name}}" value="{{$campaigncreature->name}}">
    </div>

    <div class="form-group">
        <label for="name">Current HP (Out of {{$creature->hit_points}})</label>
        <input type="text" class="form-control" id="current_hp" name="current_hp" aria-describedby="name" placeholder="{{$creature->hit_points}}" value="{{$campaigncreature->current_hp}}">
    </div>

    <div>
        <button class="btn btn-success" type="submit">Save CampaignCreature</button>
    </div>
    
    Creature Stats:
    <table style="font-size: 0.5em">
    @foreach ($creature->attributesToArray() as $index=>$creaturefield)
        @if ($index != 'id' && $index != 'created_at' && $index != 'updated_at')
            <tr><td>{{$index}}</td><td>{{$creaturefield}}</td></tr>
        @endif
    @endforeach
    </table>
</form>