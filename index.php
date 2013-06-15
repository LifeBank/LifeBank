<?php
error_reporting(E_ALL);

$url = isset($_GET['goto']) ? $_GET['goto'] : '';

require_once 'lib/config.php';

if($url == 'login') {
    // this matches /login
    require 'login.php';
}

else if($url == 'hospital/create') {
   
    include_once 'models/Hospital.php';

    $hospital = new Hospital();
    
    require 'views/hospital/create.php';
}

else if(preg_match('/^user\/(?P<user_id>[0-9]+)\/?$/', $url, $params)) {
    // this matches /user/1 or /user/23 or /user/24
    require 'profile.php';
}
else if(preg_match('/^topic\/(?P<topic_title>[a-zA-Z0-9-_\.]+)\/?$/', $url, $params)) {
    // this route will match something like
    require 'topic.php';

}else{
    require 'views/index.php';
}

?>