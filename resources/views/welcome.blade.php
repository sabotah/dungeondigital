<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        @if (App::environment('production'))
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-119904053-1"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-119904053-1');
        </script>
        @endif
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta title="Dungeon Digital - Tabletop RPG Dungeon Creator">
        <meta description="A very simple Tabletop RPG Dungeon Creator and Campaign Manager">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <!-- Add the slick-theme.css if you want default styling -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css"/>
        <!-- Add the slick-theme.css if you want default styling -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css"/>
        <title>Dungeon Digital - A very simple and Free TableTop RPG Dungeon Creator and Campaign Manager</title>


        <!-- Fonts -->
        {{-- <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css"> --}}

        <!-- Styles -->

        <style>

            body {
                overflow-x: hidden;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>

        <div>
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif
        </div>


            <div class="content" style="margin-bottom:20px; margin-top:5%">
                <div class="title m-b-md">
                    Dungeon <span class="digitalfont">Digital</span>
                </div>
                <h2>A <i><u>very</u></i> simple and <b>~Completely Free~</b> Tabletop RPG Dungeon Creator and Campaign Manager</h2>
                <h3>With DM and Character Concurrent Connectivity - More info <a href="https://www.patreon.com/dungeondigital" target="_blank">Here</a></h3>
                <h4 class="col-md-12"><a href="/register">Register</a> to Try it out!</h4><br>
                <a href="https://github.com/sabotah/dungeondigital" target="_blank"><img height=50 src="{{url('/img/GitHub-Mark.png')}}"></a>
                <a href="https://www.patreon.com/dungeondigital" target="_blank"><img height=40 src="{{url('/img/Patreon-Icon_Primary.png')}}"></a>
                        <a href="https://discord.gg/KcQeXRm"  target="_blank"><img height=45 src="{{url('/img/Discord-Logo-Color.png')}}"></a>
                        <a href="https://www.reddit.com/r/dungeondigital"  target="_blank"><img height=40 src="{{url('/img/Reddit_Mark_OnWhite.png')}}"></a>


            </div>

            <div class="row">
                <div class="col-md-4 col-sm-1"></div>
                <div class="col-md-4 col-sm-10"><iframe width="560" height="315" src="https://www.youtube.com/embed/C2KZJijRwBc" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
                <div class="col-md-4 col-sm-1"></div>
            </div>



    <div class="changelog" style="height: 200px; overflow: auto; font-size: 12px">
        <ul class="col" style="border: 1px solid black;">Change Log 2019/12/11 v0.2.7 - commit: 121
            <li>Created Room Descriptions</li>
            <li>Created Ability to Listen to Room Descriptions</li>
            <li>Can now Trigger all Characters in Campaign to Listen to Chosen Room Description</li>
        </ul>

        <ul class="col" style="border: 1px solid black;">Change Log 2018/09/09 v0.2.6 - commit: 94
            <li>Created Walls!</li>
            <li>Doors can now only be placed on walls, so it already knows the direction (no longer asks you)</li>
            <li>Because Walls are defining the room outline, you can now choose the colour for the room</li>
            <li>Added ability to edit a room</li>
            <li>Added Export to PNG button in Area and Campaign</li>
            <li>Added Toggle Gridlines button in Area and Campaign</li>
        </ul>

        <ul class="col" style="border: 1px solid black;">Change Log 2018/08/31 v0.2.1 - commit: 82
            <li>Re-styled site</li>
            <li>Created a discord Bot which allows Campaign Owners to Create a Discord channel group - Allowing Administrator Rights</li>
            <li>Campaigns can be made 'Public' which provides a Discord invite URL when a character joins a publically listed campaign</li>
            <li>Various Bug Fixes</li>
        </ul>

        <ul class="col" style="border: 1px solid black;">Change Log 2018/07/21 v0.1.3 - commit: 69
            <li>You can now edit CampaignCreature name and HP / View creature stats</li>
            <li>Campaign Characters page is now Campaign Actors, which includes CampaignCreatures Edit/View/Delete functionality</li>
        </ul>

        <ul class="col" style="border: 1px solid black;">Change Log 2018/07/21 v0.1.2 - commit: 67
            <li>Can now zoom with mousewheel in area management</li>
            <li>Default view in area management is now zoomed in quite a bit</li>
            <li>When creating rooms/environments on the right/bottom edges of an area, the area will automatically expand</li>
        </ul>

        <ul class="col" style="border: 1px solid black;">Change Log 2018/07/01 v0.1.1 - commit: 64
            <li>Room Extensions now working! You can now click on a room and draw as long as it is adjacent to the specified room. Currently only supports drawing a square/rectangle</li>
            <li>Embedded discord in campaign view! Although it uses the Titan mod, so text comes through the bot, which means certain bots (like Avrae) dont work properly</li>
        </ul>

        <ul class="col" style="border: 1px solid black;">Change Log 2018/06/04 v0.1.0 - commit: 57
            <li>Environments are now working! Hold down mousebutton and draw a complete loop (last square must end in the first)</li>
            <li>Rooms can be inside Environments, Multiple Environments stack (most recent on top)</li>
            <li>Fixed bug where character location wasnt being updated in realtime in certain situations</li>
            <li>Can now remove characters from campaign in 'Campaign Characters' section</li>
            <li>Added Help button, Help box is hidden by default now</li>
        </ul>
        <ul class="col" style="border: 1px solid black;">Change Log 2018/06/01 v0.0.2 - commit: 43
            <li>Fixed issues with low res/mobile touch events on area containers (now works on mobile; EXCEPT for touch events in area management)</li>
            <li>Added Contact button in nav</li>
            <li>Made map draggable in Area Management and defined the Area Boundry</li>
        </ul>
    	<ul class="col" style="border: 1px solid black;">Change Log 2018/05/30 v0.0.1 - commit: 39
    		<li>Removes charactervisited rows by roomid when a room is deleted (rooms get deleted properly now)</li>
    		<li>Rooms and Objects with no name are assigned: name[id]</li>
    		<li>Removed Requirement for Entity Border Curve (defaults to 0)</li>
    		<li>Added profile page for changing name, email and opt-in maillist checkbox (Under your name in the top right)</li>
    	</ul>
    </div>



<!-- <button id="playaudio">Look</button> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
{{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.slider').slick({
              dots: true,
              speed: 300,
              slidesToShow: 1,
              centerMode: true,
              centerPadding: '40px',
              variableWidth: true,
                autoplay: true,
                autoplaySpeed: 5000,
            });
        });
    </script> --}}
    <script>
$(document).ready(function() {
    // var audioElement = document.createElement('audio');
    // audioElement.setAttribute('src', '/storage/output.mp3');
    //
    // $('#playaudio').click(function() {
    //     audioElement.play();
    // });
});
    </script>
    </body>

</html>
