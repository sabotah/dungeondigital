@component('mail::message')
# <a href="https://dungeon.digital">Dungeon Digital</a> Development Update v0.1.0

<p>Thankyou for showing an interest in my little dungeon creation site!</p>

<p>I was overwelmed by the response from reddit and appreciate the feedback - Amazed to see the user count climb, spent the day refreshing google analytics (current user registration count is at: 763!)</p>

<p>I've made a few bug fixes and feature updates since going live, although I'm a couple of weeks behind the development schedule on patreon due to life commitments getting in the way.</p>

<p>Here's a copy of the changelog:</p>
<br>
<p><b>v0.1.0 - commit: 57</b></p>
<p>Environments are now working! Hold down mousebutton and draw a complete loop (last square must end in the first)</p>
<p>Rooms can be inside Environments, Multiple Environments stack (most recent on top)</p>
<p>Fixed bug where character location wasnt being updated in realtime in certain situations</p>
<p>Can now remove characters from campaign in 'Campaign Characters' section</p>
<p>Added Help button, Help box is hidden by default now</p>
<br>
<p><b>v0.0.2 - commit: 43</b></p>
<p>Fixed issues with low res/mobile touch events on area containers (now works on mobile; EXCEPT for touch events in area management)</p>
<p>Added Contact button in nav</p>
<p>Made map draggable in Area Management and defined the Area Boundry</p>
<br>
<p><b>v0.0.1 - commit: 39</b></p>
<p>Removes charactervisited rows by roomid when a room is deleted (rooms get deleted properly now)</p>
<p>Rooms and Objects with no name are assigned: name[id]</p>
<p>Removed Requirement for Entity Border Curve (defaults to 0)</p>
<p>Added profile page for changing name, email and opt-in maillist checkbox (Under your name in the top right)</p>

<hr>

<p>Now, bug testing is difficult for me, as my time is quite limited as I work fulltime. If you find a bug, please let me know on the discord server (I created a channel called 'bugreporting' - just post the issue in there, with a screenshot of the issue if possible)</p>

<p>Speaking of discord... I created a Discord server! For feature suggestions and bug fixes etc.
I currently have the Avrae and Titan bots in there, which I have been messing around with attempting to integrate into the site (titan doesnt work too well as it posts msgs back as the bot, and avrae does not pick up the originating user :( )</p>

Here's the address: 
<a href="https://discord.gg/j5sQQgh">https://discord.gg/j5sQQgh</a> (it doesnt expire)

@component('mail::button', ['url' => 'https://dungeon.digital'])
Check The Changes on the site Now!
@endcomponent

Thanks,<br>
Nic Taylor (aka 'sab')
@endcomponent
