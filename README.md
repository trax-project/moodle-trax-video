# Trax Video for Moodle

> This plugin lets you add xAPI videos into your Moodle courses .


## Installation

1. Install and configure the right version of 
[Trax Logs](https://github.com/trax-project/moodle-trax-logs) for your Moodle.

2. Download the last version of [Trax Video](https://github.com/trax-project/moodle-trax-video/releases).

3. Drag and drop the ZIP file in `http://my-moodle-address.com/admin/tool/installaddon/index.php`. 
For a manual installation, unzip the ZIP file in `my-moodle-install-folder/mod` 
and rename the plugin folder as `traxvideo`. Be sure that all the plugin files 
are located at the root of the `my-moodle-install-folder/mod/traxvideo` folder.

4. Go to the Moodle administration area. The presence of the plugin will be detected.

5. Confirm the plugin installation and follow the configuration process.

That's all. Now you can edit a course and add a **Trax Video** activity.


## Known issues

This plugin relies on the TRAX Logs LRS Proxy. Check the related
[documentation](https://github.com/trax-project/moodle-trax-logs/blob/master/doc/install.md#lrs-proxy)
if you encounter some issues. 


## How it works

**Trax Video** uses the [xAPI VideoJS](https://github.com/jhaag75/xapi-videojs) player,
which is a reference implementation of the 
[xAPI Video Profile](https://liveaspankaj.gitbooks.io/xapi-video-profile/content/) 
integrated with the VideoJS player.

With this player, you can track video events such as:
- Video started, paused, resumed, seeked, stopped.
- Interactions with the video player like audio (un)mute or resolution change.
- Video completion, time spent and viewed sections.

The video player build the related xAPI statements and send them to the server.


## Security concerns

**Trax Video** implements a secured communication between the video player
and the LRS, based on the following principles:

- The video player does not communicate directly with the LRS, 
but with an **LRS proxy** provided by the Moodle Trax Logs plugin.
The LRS credentials are not exposed here.
The Moodle authentication session is used to secure the communication. 

- The LRS proxy always **forces the actor** to match with the authenticated user,
so a user can only get and post its own statements.

- The LRS proxy communicates with the LRS **from server to server**,
using the LRS credentials stored in the Moodle Trax Logs plugin.


## Synchronicity

Trax Video sends the statements to the LRS proxy which sends them to the LRS immediately.
So the **normal process is synchronous**.

Additionally, the LRS proxy triggers a Moodle event each time it sends statements to the LRS.
These events are stored in the Moodle standard logstore.

When Trax Logs parses these logs, it ignores them and don't try to send the matching statements
because the proxy already sent them to the LRS.

However, you can force Trax Logs to resend these statements, playing with the **Resend live logs until** setting. By doing this, you can resend the Trax Video statements **asynchronously**.

The may be usefull if you want to repopulate your LRS with the Moodle logs.


## Statements

Statements sent by the VideoJS player conform with the 
[xAPI Video Profile](https://liveaspankaj.gitbooks.io/xapi-video-profile/content/).

Furthermore, **Trax Video** apply some changes for a smooth integration
with the [xAPI VLE Profile](http://doc.xapi.fr/profiles/vle) 
and the [xAPI Moodle Profile](http://doc.xapi.fr/profiles/moodle).

These changes are documented [here](http://doc.xapi.fr/profiles/moodle/events_vid).



