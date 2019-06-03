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

defined('MOODLE_INTERNAL') || die;

/**
 * Trax Video for Moodle.
 *
 * @package    mod_traxvideo
 * @copyright  2019 Sébastien Fraysse {@link http://fraysse.eu}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class backup_traxvideo_activity_structure_step extends backup_activity_structure_step {

    /**
     * Define the structure.
     */
    protected function define_structure() {

        // Define each element separated.
        $traxvideo = new backup_nested_element('traxvideo', array('id'), array(
            'name', 'intro', 'introformat', 'timemodified'));

        // Define sources.
        $traxvideo->set_source_table('traxvideo', array('id' => backup::VAR_ACTIVITYID));

        // Define file annotations
        $traxvideo->annotate_files('mod_traxvideo', 'intro', null); // This file area hasn't itemid

        // Return the root element (traxvideo), wrapped into standard activity structure.
        return $this->prepare_activity_structure($traxvideo);

    }
}
