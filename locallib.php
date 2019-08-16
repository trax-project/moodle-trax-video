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

defined('MOODLE_INTERNAL') || die();


/**
 * Mark the activity completed (if required) and trigger the course_module_viewed event.
 *
 * @param  string $eventname    event name
 * @param  stdClass $traxvideo  traxvideo object
 * @param  stdClass $course     course object
 * @param  stdClass $cm         course module object
 * @param  stdClass $context    context object
 */
function traxvideo_tigger_module_event($eventname, $traxvideo, $course, $cm, $context) {

    // Trigger course_module_viewed event.
    $params = array(
        'context' => $context,
        'objectid' => $traxvideo->id
    );
    $eventclass = '\mod_traxvideo\event\\' . $eventname;
    $event = $eventclass::create($params);
    $event->add_record_snapshot('course_modules', $cm);
    $event->add_record_snapshot('course', $course);
    $event->add_record_snapshot('traxvideo', $traxvideo);
    $event->trigger();

    // Completion.
    if ($eventname == 'course_module_viewed') {
        $completion = new completion_info($course);
        $completion->set_module_viewed($cm);
    }
}


