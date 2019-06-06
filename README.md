# Trax Video for Moodle

> This plugin let's you add video resources into your Moodle courses 
and play them with an xAPI compliant video player.


## Installation

1. Install and configure the last version of **Trax Logs** for Moodle 3.5: 
https://github.com/trax-project/moodle-trax-logs.

2. Download the last version of [Trax Video](https://github.com/trax-project/moodle-trax-video/releases) 
for Moodle 3.5.

3. Drag and drop the ZIP file in `http://my-moodle-address.com/admin/tool/installaddon/index.php`. 
For a manual installation, unzip the ZIP file in `my-moodle-install-folder/mod` 
and rename the plugin folder as `traxvideo`. Be sure that all the plugin files 
are located at the root of the `my-moodle-install-folder/mod/traxvideo` folder.

4. Go to the Moodle administration area. The presence of the plugin will be detected.

5. Confirm the plugin installation and follow the configuration process.

That's all. Now you can edit a course and add a **Trax Video** resource.


## How it works

**Trax Video** uses the [xAPI VideoJS](https://github.com/jhaag75/xapi-videojs) player,
which is is a reference implementation of the 
[xAPI Video Profile](https://liveaspankaj.gitbooks.io/xapi-video-profile/content/) 
integrated with the VideoJS player.

With this player, you can track video events such as:

- Video started, paused, resumed, seeked, stopped.
- Interactions with the video player like audio (un)mute or resolution change.
- Video completion, time spent and viewed sections.

The video player handles these events, build xAPI statements and send them an LRS.


## Security concerns

**Trax Video** uses a secured communication protocol between the video player
and the LRS, based on the following principles:

- The video player does not communicate directly with the LRS, 
but with an **LRS proxy** provided by the Trax Logs plugin.
The Moodle authentication session is used to secure this communication,
so the LRS credentials are not exposed here.

- The LRS proxy always forces the actor to match with the authenticated user,
so a user can only request and post its own statements.

- The LRS proxy communicates with the LRS from server to server,
using the LRS credentials.


## Statements

Statements sent by the VideoJS player conform with the 
[xAPI Video Profile](https://liveaspankaj.gitbooks.io/xapi-video-profile/content/).

Furthermore, **Trax Video** apply some changes for a smooth integration
with the [xAPI VLE Profile](http://doc.xapi.fr/profiles/vle) 
and the [xAPI Moodle Profile](http://doc.xapi.fr/profiles/moodle).

These changes are documented [here](http://doc.xapi.fr/profiles/moodle/events_vid).



