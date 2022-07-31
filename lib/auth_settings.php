<?php

require_once('../../../config.php');

require_login();

require_capability("local/zoho_auth:manage", context_system::instance());

$url = new moodle_url('/local/zoho_auth/lib/auth_settings.php');
$PAGE->set_pagelayout('admin');
$PAGE->set_context(context_system::instance());
$PAGE->set_url($url);
$PAGE->set_title(get_string('auth_settings_title', 'local_zoho_auth'));


echo $OUTPUT->header();

$mform = new \local_zoho_auth\settings_form($url);

$configs = $DB->get_records_sql("select * from {config} where name like '%zoho_auth%'");

if ($configs) {
    $data = array();
    foreach ($configs as $config) {
        $data[$config->name] = $config->value;
    }

    $mform->set_data($data);
}

$fromform = $mform->get_data();

if ($fromform) {

    foreach ($fromform as $key => $value) {
        if (strpos($key, 'zoho_auth') === false) continue;

        $exists = $DB->get_record('config', array('name' => $key));

        if (!$exists) {
            $exists = new \stdClass();
            $exists->name = $key;
            $exists->value = $value;
            $DB->insert_record('config', $exists);
        } else if ($exists->value != $value) {
            $exists->value = $value;
            $DB->update_record('config', $exists);
        }
    }

    redirect($url, get_string('changes_saved', 'local_zoho_auth'), 2);
} else {
    $mform->display();
}


echo $OUTPUT->footer();
