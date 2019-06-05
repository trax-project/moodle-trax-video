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

require_once($CFG->dirroot.'/course/moodleform_mod.php');

class mod_traxvideo_mod_form extends moodleform_mod {

    function definition() {
        $config = get_config('traxvideo');
        $mform = $this->_form;

        // General settings.
        $mform->addElement('header', 'general', get_string('general', 'form'));

        // Name.
        $mform->addElement('text', 'name', get_string('name'));
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');

        // Summary.
        $this->standard_intro_elements();

        // Poster.
        $mform->addElement('text', 'poster', get_string('poster', 'traxvideo'));
        $mform->setType('poster', PARAM_TEXT);
        $mform->addRule('poster', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
        $mform->addHelpButton('poster', 'poster', 'traxvideo');
        $mform->setDefault('poster', 'http://vjs.zencdn.net/v/oceans.png');

        // Poster.
        $mform->addElement('text', 'sourcemp4', get_string('sourcemp4', 'traxvideo'));
        $mform->setType('sourcemp4', PARAM_TEXT);
        $mform->addRule('sourcemp4', null, 'required', null, 'client');
        $mform->addRule('sourcemp4', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
        $mform->addHelpButton('sourcemp4', 'sourcemp4', 'traxvideo');
        $mform->setDefault('sourcemp4', 'http://vjs.zencdn.net/v/oceans.mp4');

        // Common settings.
        $this->standard_coursemodule_elements();

        // Submit buttons.
        $this->add_action_buttons();
    }

}

