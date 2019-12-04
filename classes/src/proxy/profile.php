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
 * Proxy video profile.
 *
 * @package    mod_traxvideo
 * @copyright  2019 Sébastien Fraysse {@link http://fraysse.eu}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_traxvideo\src\proxy;

defined('MOODLE_INTERNAL') || die();

use logstore_trax\src\proxy\profile as base_profile;

/**
 * Proxy video profile.
 *
 * @package    mod_traxvideo
 * @copyright  2019 Sébastien Fraysse {@link http://fraysse.eu}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class profile extends base_profile {

    /**
     * Transform a statement (hook).
     *
     * @param \stdClass $statement Statement to transform
     * @return void
     */
    protected function transform(&$statement) {

        // Remove object description.
        if (isset($statement->object->definition->description)) {
            unset($statement->object->definition->description);
        }

        // Add parent activity.
        $statement->context->contextActivities->parent = [
            $this->activities->get('traxvideo', $this->activity->id, false, 'module', 'traxvideo', 'mod_traxvideo')
        ];
        
        // Modify video category.
        foreach ($statement->context->contextActivities->category as &$category) {
            if ($category->id == 'https://w3id.org/xapi/video') {
                $category->definition = [
                    'type' => 'http://adlnet.gov/expapi/activities/profile'
                ];
            }
        }
    }

}
