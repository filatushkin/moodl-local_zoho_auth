<?php

defined('MOODLE_INTERNAL') || die;

// Just a link to course report.
$ADMIN->add('root', new admin_externalpage(
        'local_zoho_auth_settings',
        get_string('settings', 'local_zoho_auth'),
        $CFG->wwwroot . "/local/zoho_auth/lib/auth_settings.php",
        'report/log:view'
));

// No report settings.
$settings = null;
