<?php


function local_zoho_auth_myprofile_navigation(core_user\output\myprofile\tree $tree, $user, $iscurrentuser, $course)
{

    global $PAGE, $CFG, $USER;

    if (isguestuser($user)) {
        return false;
    }

    if ($user->id != $USER->id) {
        return false;
    }
    $url = $CFG->wwwroot . '/local/zoho_auth/auth.php';

    $node = new core_user\output\myprofile\node(
        'miscellaneous',
        'gotozoho',
        get_string('gotozoho', 'local_zoho_auth'),
        null,
        $url
    );

    $tree->add_node($node);
}
