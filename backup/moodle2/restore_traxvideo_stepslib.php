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

/**
 * Trax Video for Moodle.
 *
 * @package    mod_traxvideo
 * @copyright  2019 Sébastien Fraysse {@link http://fraysse.eu}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class restore_traxvideo_activity_structure_step extends restore_activity_structure_step {

    /**
     * Define the structure.
     */
    protected function define_structure() {
        $paths = array();
        $paths[] = new restore_path_element('traxvideo', '/activity/traxvideo');
        return $this->prepare_activity_structure($paths);
    }

    /**
     * Process.
     * 
     * @param stdClass $data 
     */
    protected function process_traxvideo($data) {
        global $DB;
        $data = (object)$data;
        $oldid = $data->id;
        $data->course = $this->get_courseid();
        $newitemid = $DB->insert_record('traxvideo', $data);
        $this->apply_activity_instance($newitemid);
    }

    /**
     * After execute.
     */
    protected function after_execute() {
        $this->add_related_files('mod_traxvideo', 'intro', null);
    }
}
