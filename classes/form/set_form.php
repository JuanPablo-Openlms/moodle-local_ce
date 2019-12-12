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
 * Set form.
 *
 * @package    local_ce
 * @author     David Castro <david.castro@blackboard.com>
 * @copyright  Copyright (c) 2018 Blackboard Inc. (http://www.blackboard.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_ce\form;

defined('MOODLE_INTERNAL') || die('Forbidden.');

require_once("$CFG->libdir/formslib.php");

use local_ce\model\set;
use moodleform;

/**
 * Set form.
 *
 * @package    local_ce
 * @author     David Castro <david.castro@blackboard.com>
 * @copyright  Copyright (c) 2018 Blackboard Inc. (http://www.blackboard.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class set_form extends moodleform {

    protected function definition() {
        $mform = $this->_form;

        // Adding the standard "name" field.
        $mform->addElement('text', 'name', get_string('set_form_name', 'local_ce'), ['size' => '30']);
        $mform->setType('name', PARAM_TEXT);

        $statusopts = [
            set::SET_STATUS_DRAFT     => get_string('statusdraft', 'local_ce'),
            set::SET_STATUS_PUBLISHED => get_string('statuspublished', 'local_ce'),
        ];
        $mform->addElement('select', 'status', get_string('set_form_status', 'local_ce'), $statusopts);
        $mform->setType('status', PARAM_INT);

        $mform->addElement('course', 'courseids', get_string('courses'), [
            'multiple' => true,
            'includefrontpage' => true,
            'noselectionstring' => get_string('allcourses', 'search')
        ]);

        $capabilityopts = [
            ''                            => get_string('nocapability', 'local_ce'),
            'local/ce:learnerset_view'    => get_string('ce:courseset_view', 'local_ce'),
            'local/ce:instructorset_view' => get_string('ce:learnerset_view', 'local_ce'),
        ];
        $mform->addElement('select', 'requiredcapability', get_string('set_form_requiredcapability', 'local_ce'),
            $capabilityopts);
        $mform->setType('requiredcapability', PARAM_TEXT);

        $iconoptions = $this->get_iconfile_options(true);
        $mform->addElement('filemanager', 'iconfileid', get_string('set_form_iconfile', 'local_ce'), null, $iconoptions);

        $this->add_action_buttons(false);
    }

    public function validation($data, $files) {
        return parent::validation($data, $files); // TODO: Change the autogenerated stub
    }

    /**
     * @param bool $forform
     * @return array
     */
    public function get_iconfile_options($forform = false) {
        $opts = [
            'subdirs' => 0,
            'maxbytes' => 0,
            'maxfiles' => 1,
        ];

        if ($forform) {
            $opts['accepted_types'] = [
                'web_image'
            ];
            $opts['return_types'] = FILE_INTERNAL | FILE_EXTERNAL;
        }

        return $opts;
    }

}