<form action="/characters/{{$character->id}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" aria-describedby="name" placeholder="{{$character->name}}" value="{{$character->name}}">
    </div>

    <div class="form-group">
        <label for="name">Class</label>
        <input type="text" class="form-control" id="class" name="class" aria-describedby="class" placeholder="{{$character->class}}" value="{{$character->class}}">
    </div>

    <div class="form-group">
        <label for="name">Race</label>
        <input type="text" class="form-control" id="race" name="race" aria-describedby="race" placeholder="{{$character->race}}" value="{{$character->race}}">
    </div>
    
        @if ($character->charsheet)
            <div><a target="_blank" href="{{url(str_replace('public/','/storage/',$character->charsheet))}}">Existing Character Sheet</a></div>
        @endif

    <div class="custom-file">

        <input type="file" class="custom-file-input" id="charsheetfile" name="charsheetfile" placeholder="In Image (jpeg, png, gif) or PDF format">
        <label class="custom-file-label" for="charsheetfile">Replace Character Sheet...</label>
    </div>

    <div>
        <button class="btn btn-success" type="submit">Edit Character</button>
    </div>
    
</form>

<script>
$('#charsheetfile').change(function() {
    console.log('here');
  var file = $('#charsheetfile')[0].files[0].name;
  $('.custom-file-label').html(file);
});
</script>