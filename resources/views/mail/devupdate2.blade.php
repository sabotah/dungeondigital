@component('mail::message')
# <a href="https://dungeon.digital">Dungeon Digital</a> Development Update v0.1.3

<p>OK! So, Finally had some spare time over the last couple o days to do some work on the site</p>

<p>these Four new features are now live:</p>

<h3>1. Room Extensions</h3>
<div>
<img src="{{url('/ddgifs/roomextension.gif')}}">
</div>

<h3>2. Auto Expanding Area (Only to the Right and Bottom)</h3>
<div>
<img src="{{url('/ddgifs/expandingarea.gif')}}">
</div>

<h3>3. Edit CampaignCreature </h3>
<div>
<img src="{{url('/ddgifs/editcreature.gif')}}">
</div>

<h3>3. Campaign Actors Section</h3>
<div>
<img src="{{url('/ddgifs/campaignactors.gif')}}">
</div>

<p>Next up, create custom creatures (that display in the search when adding campaigncreatures) and a tickbox to 'ignore d&d creatures'</p>
<p>Which reminds me... if anyone knows where I can get some legally free creature data for other tabletop rpg systems, let me know and I'll import it in!</p>

<p>If you want to report Bugs or discuss features, feel free to join the Discord server:</p> 
<a href="https://discord.gg/j5sQQgh">https://discord.gg/j5sQQgh</a> (it doesnt expire)

@component('mail::button', ['url' => 'https://dungeon.digital'])
Check out the Changes on the site Now!
@endcomponent

Thanks again for your support,<br>
Nic Taylor (aka 'sab')
@endcomponent
