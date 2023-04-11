<!DOCTYPE html>
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

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Dungeon Digital') }}</title>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- Styles -->
    <link rel="stylesheet" media="screen" type="text/css" href="/css/colorpicker/colorpicker.css" />

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

    <link href="//cdn.rawgit.com/noelboss/featherlight/1.7.13/release/featherlight.min.css" type="text/css" rel="stylesheet" />
    
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    Dungeon <span class="digitalfont">Digital</span>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @if (\Auth::user())
                    <ul class="navbar-nav mr-auto">
                        <li><a href="/home"><button class="btn btn-primary">Home</button></a></li>
                        <li><a href="/areas"><button class="btn btn-primary">Area Management</button></a></li>
                        {{-- <li><a href="/rollrequests"><button class="btn btn-primary">Roll Requests</button></li> --}}
 {{--                        <li><a href="/characters"><button class="btn btn-primary">Characters</button></a></li>
                        <li><a href="/campaigns"><button class="btn btn-primary">Campaigns</button></a></li> --}}
                        <li><a href="/campaigncharacters"><button class="btn btn-primary">Campaign Actors</button></a></li>
                        <li><button class="btn btn-warning" data-featherlight="/feedbackform">Report Bugs/Suggestions! I need your Feedback</button></li>

                    </ul>
                    @endif

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="pull-right">
                            <a href="https://www.patreon.com/dungeondigital"><img height=30 src="{{url('/img/Patreon-Icon_Primary.png')}}"></a>
                        <a href="https://discord.gg/KcQeXRm" style="margin-left: 10px; margin-right: 10px"><img height=40 src="{{url('/img/Discord-Logo-Color.png')}}"></a>
                        <a href="https://www.reddit.com/r/dungeondigital"><img height=33 src="{{url('/img/Reddit_Mark_OnWhite.png')}}"></a>

                        
                        </li>
                        <!-- Authentication Links -->
                        @guest
                            <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                            <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="/users/{{\Auth::user()->id}}">Profile</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
@if (session('error'))
    <div class="alert alert-warning">
        {{ session('error') }}
    </div>
@endif

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
            @yield('content')
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
<script type="text/javascript" src="/js/colorpicker/colorpicker.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

<script src="/js/touchpunch/jquery.ui.touch-punch.min.js"></script>

<script src="//cdn.rawgit.com/noelboss/featherlight/1.7.13/release/featherlight.min.js" type="text/javascript" charset="utf-8"></script>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
        <!-- Scripts -->
    @yield('scripts')
</body>
<footer class="footer">
<a href="/privacypolicy"><small>PRIVACY POLICY</small></a> | <a href="/dndlicense"><small>D&D OPEN GAME LICENSE</small></a> | <a href="https://www.patreon.com/dungeondigital" target="_blank"><img src="/img/become_a_patron_button.png" height="30"></a> | 
                        <a href="https://discord.gg/KcQeXRm"><img height=30 src="{{url('/img/Discord_button.png')}}"></a> | 
                        <a href="https://www.reddit.com/r/dungeondigital"><img height=33 src="{{url('/img/Reddit_Mark_OnWhite.png')}}"></a>
</footer>
</html>
