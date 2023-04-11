@component('mail::message')
# <a href="https://dungeon.digital">Dungeon Digital</a> Development Update v0.2.6

<p>No Fancy anim-gifs this time :) just a nice simple paste of what I have been upto on the site recently - I'll let you do the exploring</p>

<p>Here's a breakdown of the changelog since the last update on July 21st:</p>

<ul style="border: 1px solid black;">Change Log 2018/09/09 v0.2.6 - commit: 94
    <li>Created Walls!</li>
    <li>Doors can now only be placed on walls, so it already knows the direction (no longer asks you)</li>
    <li>Because Walls are defining the room outline, you can now choose the colour for the room</li>
    <li>Added ability to edit a room</li>
    <li>Added Export to PNG button in Area and Campaign</li>
    <li>Added Toggle Gridlines button in Area and Campaign</li>
</ul>

<ul style="border: 1px solid black;">Change Log 2018/08/31 v0.2.1 - commit: 82
    <li>Re-styled site</li>
    <li>Created a discord Bot which allows Campaign Owners to Create a Discord channel group - Allowing Administrator Rights</li>
    <li>Campaigns can be made 'Public' which provides a Discord invite URL when a character joins a publically listed campaign</li>
    <li>Various Bug Fixes</li>
</ul>

<p>Feel free to join the public discord to report bugs or let me know any suggestions you might have! :)</p>

<p><a href="https://discord.gg/KcQeXRm">https://discord.gg/KcQeXRm</a></p>

@component('mail::button', ['url' => 'https://dungeon.digital'])
Check out the Changes on the site Now!
@endcomponent

Thanks again for your support,<br>
Nic Taylor (aka 'sab')
@endcomponent
