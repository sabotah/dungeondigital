<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-119904053-1"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-119904053-1');
        </script>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <!-- Add the slick-theme.css if you want default styling -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css"/>
        <!-- Add the slick-theme.css if you want default styling -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css"/>
        <title>Dungeon Digital</title>

        <!-- Fonts -->
        {{-- <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css"> --}}

        <!-- Styles -->
        
        <style>

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


            <div class="content" style="margin-bottom:10%; margin-top:5%">
                <div class="title m-b-md">
                    Privacy Policy</span>
                </div>
            </div>


<p>Last updated: 29/05/2018</p>

<p>Nicholas Taylor (nic@nic.id.au) operates  https://dungeon.digital - This current page informs you of policies regarding the collection, use and disclosure of Personal Information I receive from users of the Site.</p>

<p>I use your Personal Information only for providing and improving the Site. By using the Site, you agree to the collection and use of information in accordance with this policy.</p>

<h3>Information Collection And Use</h3>

<p>While using this Site, I may ask you to provide me with certain personally identifiable information that can be used to contact or identify you. Personally identifiable information is your name and email address.</p>

<h3>Log Data</h3>

<p>I keep no browser data stored within the site database, however I do use the third party service Google Analytics that collect, monitor and analyze the data</p>


<h3>Communications</h3>

<p>I may use your Personal Information to contact you with Development updates, but only if you opt-in to this service on signup; Other than specific emails to notify you of a change in the Privacy Policy</p>

<h3>Cookies</h3>

<p>Cookies are files with small amount of data, which may include an anonymous unique identifier. Cookies are sent to your browser from a web site and stored on your computer's hard drive.</p>

<p>Like many sites, I use "cookies" to collect information. You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent. However, if you do not accept cookies, you may not be able to use some portions of our Site.</p>

<h3>Security</h3>

<p>The security of your Personal Information is important, but remember that no method of transmission over the Internet, or method of electronic storage, is 100% secure. While I strive to use commercially acceptable means to protect your Personal Information, I cannot guarantee its absolute security.</p>

<p>In saying this, the password is salted and hashed upon registration, and the website is using SSL encryption (HTTPS)</p>

<h3>Changes To This Privacy Policy</h3>

<p>This Privacy Policy is effective as of 29/05/2018 and will remain in effect except with respect to any changes in its provisions in the future, which will be in effect immediately after being posted on this page.</p>

<p>I reserve the right to update or change the Privacy Policy at any time and you should check this Privacy Policy periodically. Your continued use of the Service after I post any modifications to the Privacy Policy on this page will constitute your acknowledgment of the modifications and your consent to abide and be bound by the modified Privacy Policy.</p>

<p>If I make any material changes to this Privacy Policy, I will notify you either through the email address you have provided us, or by placing a prominent notice on the website.</p>

<h3>Contact</h3>

<p>If you have any questions about this Privacy Policy, please contact me on nic@nic.id.au</p>

    </body>
</html>
