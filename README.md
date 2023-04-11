# Dungeon Digital

This is the official open source GitHub repo for the site: https://dungeon.digital

It's a very simple RPG Dungeon Builder and Campaign Manager, but object oriented and realtime multiplayer

coded in Laravel 10 (recently upgraded from laravel 5, so forgive the occasional legacy coding structure)

Current Functionality:

DM can:
- create a campaign (with the option to automatically create a text and voice chat group for the campaign in the official dungeon digital discord)
- create multiple areas with environments (draw any shape, as long as the first cell is the last cell), rooms (rectangles), objects, doors and pick which areas are assigned to what campaigns
- search an email address to add unassigned characters to campaign
- manage campaign: 
    - Assign characters to rooms
    - Add creatures (if the game is D&D, it uses the creature list from the OGL 1.0a)
    - Drag Actors to any room and even stack them ontop of each other.
    - text-to-speech read out the room description to all characters at the same time, with the click of a button
    
Characters can:
- Only see other characters and creatures in their current room, yet remember what rooms they have been in (greyed out)
- Can request movement to a square, the DM can approve it by clicking on a silhouette which will move the character to requested square
