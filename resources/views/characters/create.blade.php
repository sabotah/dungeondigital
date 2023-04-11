<div class="container">
    <div class="row">
        <div class="col">
            <form action="/characters" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" aria-describedby="name" placeholder="Enter Character Name">
                </div>

                <div class="form-group">
                    <label for="class">Class</label>
                    <input type="text" class="form-control" id="class" name="class" aria-describedby="class" placeholder="Enter Class e.g. Warrior, Mage, Paladin">
                </div>

                <div class="form-group">
                    <label for="race">Race</label>
                    <input type="text" class="form-control" id="race" name="race" aria-describedby="race" placeholder="Enter Race e.g. Elf, Human, Dwarf">
                </div>

{{--                 <div class="form-group">
                    <label for="charsheet">Enter URL of Character Sheet</label>
                    <input type="text" class="form-control" id="charsheet" name="charsheet" aria-describedby="charsheet" placeholder="This is a Game Only function">
                </div> --}}

                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="charsheetfile" name="charsheetfile" placeholder="In Image (jpeg, png, gif) or PDF format">
                    <label class="custom-file-label" for="charsheetfile">Upload Character Sheet...</label>
                </div>

                <div>
                    <button class="btn btn-primary" type="submit">Create Character</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$('#charsheetfile').change(function() {
    console.log('here');
  var file = $('#charsheetfile')[0].files[0].name;
  $('.custom-file-label').html(file);
});
</script>