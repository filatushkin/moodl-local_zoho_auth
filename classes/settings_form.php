<?php

namespace local_zoho_auth;

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/formslib.php");

class settings_form extends \moodleform
{

    //Add elements to form
    public function definition()
    {
        global $CFG, $DB, $USER, $_SERVER;

        $mform = $this->_form;
        
        $mform->addElement('html', '<h3>' . get_string('auth_settings_title', 'local_zoho_auth') . '</h3>');

        $mform->addElement('text', 'auth_url', get_string('auth_url', 'local_zoho_auth'), array('size' => '20', 'disabled' => 1));
        $mform->setType('auth_url', PARAM_TEXT);
        $mform->setDefault('auth_url', 'https://yourdomain.com/RemoteAuth');

        $mform->addElement('text', 'your_public_ip', get_string('your_public_ip', 'local_zoho_auth'), array('size' => '20', 'disabled' => 1));
        $mform->setType('your_public_ip', PARAM_TEXT);
        $mform->setDefault('your_public_ip', $_SERVER['REMOTE_ADDR']);

        $mform->addElement('text', 'zoho_auth_remotekey', get_string('remote_key', 'local_zoho_auth'), array('size' => '20'));
        $mform->setType('zoho_auth_remotekey', PARAM_TEXT);
        $mform->setDefault('zoho_auth_remotekey', '');

        $buttonarray = array();
        $buttonarray[] = $mform->createElement('submit', 'save', 'Save');
        $buttonarray[] = $mform->createElement('cancel');

        $mform->addGroup($buttonarray, 'buttonar', '', ' ', false);
    }
}
