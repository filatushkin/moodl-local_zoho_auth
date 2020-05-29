<?php
require_once('../../config.php');

//get configs
$configs = $DB->get_records_sql("select name,value from {config} where name = 'zoho_auth_remotekey'");

//if not active skip
if(!$configs['zoho_auth_remotekey']->value) {
    
    redirect(
        $CFG->wwwroot,
        'Sorry, something went wrong! Your Zoho Remote Auth Key is missing! Please contact website administrator!',
        30);
        
    return false;
}


$remoteauthkey = $configs['zoho_auth_remotekey']->value;

$operation = "signin";
$email = $USER->email;
$ts = round(microtime(true) * 1000);
 
$apikey = md5($operation.$email.$remoteauthkey.$ts);
 
$login_url = "https://support.apcollege.edu.au/support/RemoteAuth?".
        "operation=" . urlencode($operation) . 
        "&email=".urlencode($email) . 
        "&ts=" . urlencode($ts) . 
        "&apikey=" . $apikey;

$result_json = json_decode(file_get_contents($login_url), true);

//redirect and login 
if(!$result_json){
   header('Location: '.$login_url); 
   
//sign up
} else if($result_json['result'] == 'failure' && $result_json['cause'] == 'E110 - No Such User or User Deactivated'){
    //create user
    $operation = "signup";
    $email = $USER->email;
    $email_parts = explode("@", $USER->email);
    $loginname = $email_parts[0];
    //$loginname = $USER->username;
    $fullname = $USER->firstname . ' ' . $USER->lastname;
    $utype = 'portal';
    $redirect = 1;
    $ts = round(microtime(true) * 1000);

    $apikey = md5($operation.$email.$loginname.$fullname.$utype.$remoteauthkey.$ts);
     
    $signup_url = "https://support.apcollege.edu.au/support/RemoteAuth?operation=" . urlencode($operation) . 
        "&email=".urlencode($email) .
        "&loginname=" .urlencode($loginname). 
        "&fullname=".urlencode($fullname).
        "&utype=".urlencode($utype).
        "&ts=" . urlencode($ts) . 
        "&apikey=" . $apikey.
        "&redirect=".$redirect;
    
    header('Location: '.$signup_url);
    
} else {
    //throw error
    redirect(
        $CFG->wwwroot.'/user/profile.php?id='.$USER->id,
        'Sorry, something went wrong! Remote authentication returned a wrong status! Please contact site admin!',
        30);
}
