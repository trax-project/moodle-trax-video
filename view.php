<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Trax Video for Moodle.
 *
 * @package    mod_traxvideo
 * @copyright  2019 Sébastien Fraysse {@link http://fraysse.eu}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->dirroot . '/mod/traxvideo/lib.php');

// Params.
$id = required_param('id', PARAM_INT); 

// Objects.
$cm = get_coursemodule_from_id('traxvideo', $id, 0, false, MUST_EXIST);
$course = $DB->get_record("course", array('id' => $cm->course), '*', MUST_EXIST);
$activity = $DB->get_record("traxvideo", array('id' => $cm->instance), '*', MUST_EXIST);

// Permissions.
require_course_login($course, true, $cm);
$context = context_module::instance($cm->id);
require_capability('mod/traxvideo:view', $context);

// Completion and trigger events.
traxvideo_view($activity, $course, $cm, $context);

// Page setup.
require_login($course->id, false, $cm);
$url = new moodle_url('/mod/traxvideo/view.php', array('id'=>$id));
$PAGE->set_url($url);

// External file.
$PAGE->requires->css(new moodle_url($CFG->wwwroot . '/mod/traxvideo/players/xapi-videojs/video-js-6.1.0/video-js.css'));
$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/mod/traxvideo/players/xapi-videojs/video-js-6.1.0/ie8/videojs-ie8.min.js'), true);
$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/mod/traxvideo/players/xapi-videojs/video-js-6.1.0/video.js'), true);
$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/mod/traxvideo/players/xapi-videojs/xAPIWrapper-1.10.4/src/xapiwrapper.js'), true);
$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/mod/traxvideo/players/xapi-videojs/xAPIWrapper-1.10.4/lib/cryptojs_v3.1.2.js'), true);
$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/mod/traxvideo/players/xapi-videojs/xapi-videojs.js'), true);

// Content header.
$title = format_string($activity->name);
$PAGE->set_title($title);
$PAGE->set_heading($course->fullname);
echo $OUTPUT->header();
echo $OUTPUT->heading($title);

// Front data.
$front = (object)[
    'endpoint' => $CFG->wwwroot . '/admin/tool/log/store/trax/proxy/',
    'username' => '',
    'password' => '',
    'actor' => '{"mbox": "mailto:videojs@video.profile.xapi"}',
    'video' => [
        'video/mp4' => 'http://vjs.zencdn.net/v/oceans.mp4',
        'video/webm' => 'http://vjs.zencdn.net/v/oceans.webm',
        'video/ogg' => 'http://vjs.zencdn.net/v/oceans.ogv',
    ],
    'poster' => 'http://vjs.zencdn.net/v/oceans.png',
];
?>

<video id="xapi-videojs" class="video-js vjs-default-skin" controls preload="auto" width="640" height="264" 
    poster="<?php echo $front->poster ?>" data-setup="{}">
    <?php 
    foreach ($front->video as $type => $source) {
        echo '<source src="' . $source . '" type="' . $type . '">';
    }
    ?>
</video>

<script type="text/javascript">

    ADL.XAPIWrapper.log.debug = false;
    if (ADL.XAPIWrapper.lrs.auth == undefined) {
        var conf = {
            "endpoint": "<?php echo $front->endpoint ?>",
            "auth": "Basic " + toBase64('<?php echo $front->username ?>:<?php echo $front->password ?>'),
            "actor": '<?php echo $front->actor ?>'
        };
        ADL.XAPIWrapper.changeConfig(conf);
    }
    var activityTitle = 'xAPI Video';
    var activityDesc = 'Video conforming with the xAPI video profile';
    ADL.XAPIVideoJS("xapi-videojs");

</script>

<?php
// Content close.
echo $OUTPUT->footer();

