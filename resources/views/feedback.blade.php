<div class="container">
    <div class="row">
        <div class="col">
            <form action="/feedbackform" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <h3>Feedback</h3>
                    <label for="feedback">Report bugs or let me know what you want from the site (or what you think of it).
                        <br>I'm not in a campaign anymore so I can't test it!
                        <br>Alternatively, join the discord server and real time chat with me about it: <a href="https://discord.gg/KcQeXRm" style="margin-left: 10px; margin-right: 10px"><img height=40 src="{{url('/img/Discord_button.png')}}"></a></label>
                    <textarea style="width: 100%; height: 300px" class="form-control" id="feedback" name="feedback" aria-describedby="name" placeholder="Talk to me!"></textarea>
                </div>

                <div>
                    <button class="btn btn-primary" type="submit">Send me Feedback!</button>
                </div>
            </form>
        </div>
    </div>
</div>