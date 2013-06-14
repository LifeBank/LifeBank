<?php
// General functions

function logout() {
}

// Escapes user input for injections
function escape($input) {
  /*
  $input = trim($input);

  if (get_magic_quotes_gpc ()) {
    $input = stripslashes($input);
  }

  // Normalize newlines
  $input = str_replace("\r", "\n", $input);
  $input = preg_replace("/\n\n+/", "\n", $input);

  // Escape HTML
  $input = htmlentities($input, ENT_QUOTES, 'UTF-8');

  return mysql_real_escape_string($input);  
  //*/
}

// Get the session parameter from passed key
function get_session_parameter($key) {
}

// Get gravatar from email
function get_gravatar($email, $s = 48, $d = 'mm', $r = 'g', $img = false, $atts = array()) {
  $url = 'http://www.gravatar.com/avatar/';
  $url .= md5(strtolower(trim($email)));
  $url .= "?s=$s&d=$d&r=$r";
  
  if ($img) {
    $url = '<img src="' . $url . '"';
    foreach ($atts as $key => $val)
      $url .= ' ' . $key . '="' . $val . '"';
    $url .= ' />';
  }
  
  return $url;
}


// Log (super and hospital) admin activities
function log_activity($object, $id, $action) {
}

// Display error in session (and unset session variable?)
function get_error() {
}

// TODO:
function get_notifications($filters) {
}