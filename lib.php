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
 * Return the list if Moodle features this module supports.
 *
 * @param string $feature FEATURE_xx constant for requested feature
 * @return mixed True if module supports feature, null if doesn't know
 */
function traxvideo_supports($feature) {
    switch ($feature) {
        case FEATURE_MOD_ARCHETYPE:
            return MOD_ARCHETYPE_RESOURCE;
        case FEATURE_GROUPS:
            return false;
        case FEATURE_GROUPINGS:
            return false;
        case FEATURE_MOD_INTRO:
            return true;
        case FEATURE_COMPLETION_TRACKS_VIEWS:
            return true;
        case FEATURE_COMPLETION_HAS_RULES:
            return false;
        case FEATURE_GRADE_HAS_GRADE:
            return false;
        case FEATURE_GRADE_OUTCOMES:
            return false;
        case FEATURE_BACKUP_MOODLE2:
            return true;
        case FEATURE_SHOW_DESCRIPTION:
            return true;
        case FEATURE_ADVANCED_GRADING:
            return false;
        case FEATURE_PLAGIARISM:
            return false;
        case FEATURE_COMMENT:
            return true;
        default:
            return null;
    }
} 

/**
 * Add traxvideo instance.
 * 
 * @param stdClass $data
 * @param mod_traxvideo_mod_form $mform
 * @return int new traxvideo instance id
 */
function traxvideo_add_instance($data, $mform = null) {
    global $DB;

    // Set data.
    $data->timemodified = time();

    // Record it.
    $data->id = $DB->insert_record('traxvideo', $data);
    return $data->id;
}

/**
 * Update traxvideo instance.
 * 
 * @param object $data
 * @param object $mform
 * @return bool true
 */
function traxvideo_update_instance($data, $mform) {
    global $DB;

    // Set data.
    $data->timemodified = time();
    $data->id = $data->instance;

    // Record it.
    $DB->update_record('traxvideo', $data);
    return true;
}

/**
 * Delete traxvideo instance.
 * 
 * @param int $id
 * @return bool true
 */
function traxvideo_delete_instance($id) {
    global $DB;

    // Check existence.
    if (!$traxvideo = $DB->get_record('traxvideo', array('id'=>$id))) {
        return false;
    }

    // Delete it.
    $DB->delete_records('traxvideo', array('id'=> $traxvideo->id));
    return true;
}

/**
 * Returns all other caps used in module.
 * 
 * @return array
 */
function traxvideo_get_extra_capabilities() {
    return array('moodle/site:accessallgroups');
}

/**
 * This function is used by the reset_course_userdata function in moodlelib.
 * 
 * @param $data the data submitted from the reset course.
 * @return array status array
 */
function traxvideo_reset_userdata($data) {
    return array();
}

/**
 * Mark the activity completed (if required) and trigger the course_module_viewed event.
 *
 * @param  stdClass $traxvideo  traxvideo object
 * @param  stdClass $course     course object
 * @param  stdClass $cm         course module object
 * @param  stdClass $context    context object
 * @since Moodle 3.0
 */
function traxvideo_view($traxvideo, $course, $cm, $context) {

    // Trigger course_module_viewed event.
    $params = array(
        'context' => $context,
        'objectid' => $traxvideo->id
    );

    $event = \mod_traxvideo\event\course_module_viewed::create($params);
    $event->add_record_snapshot('course_modules', $cm);
    $event->add_record_snapshot('course', $course);
    $event->add_record_snapshot('traxvideo', $traxvideo);
    $event->trigger();

    // Completion.
    $completion = new completion_info($course);
    $completion->set_module_viewed($cm);
}


