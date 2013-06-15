<?php
// error_reporting(E_ALL);
$url = isset($_GET['goto']) ? $_GET['goto'] : '';

require_once 'lib/config.php';
require_once 'models/Functions.php';

if($url == 'logout') {
  logout();
}
else if($url == 'hospital/create') {
  include_once 'models/Hospital.php';
  $hospital = new Hospital();    
  require 'views/hospital/create.php';
}
else if ($url == 'user/settings') {
  include_once 'models/User.php';
  $user = new User;
  
  require 'views/user/settings.php';
}
else if ($url == 'user/signup') {
  include_once 'models/User.php';
  $user = new User;
  
  if ($_POST) {
    $_POST['password'] = $_SESSION['tmp']['password'];
    $_SESSION['tmp'] = $_POST;
    if ($user->signup($_POST['username'], $_POST['name'], $_SESSION['tmp']['email'], $_SESSION['tmp']['password'], $_POST['phone'], $_POST['blood_type'], $_POST['location'])) {
      header('location:../'.$_POST['username']);
      exit;
    }
    else {
    }
  }
  
  require 'views/user/register.php';
}
else {
  if (empty($url)) {
    // Default page
    if ($_POST['email'] && $_POST['password']) {
      if (isset($_POST['signup'])) {
        $_SESSION['tmp'] = array(
            'email' => $_POST['email'],
            'password' => $_POST['password']
          );
        header("location:user/signup");
        exit;
      }
      else if (isset($_POST['signin'])) {
        include_once 'models/User.php';
        $user = new User;
        if ($user->login($_POST['email'], $_POST['password'])) {
          header("location:".$_SESSION['user']['username']);
          exit;
        }
      }
    }
    
    require 'views/index.php';
  }
  else {
    // Userpage?
    include_once 'models/User.php';
    $userModel = new User;
    $user = $userModel->get_user($url);
    if ($user) {
      $user['blood_group'] = $user['blood_group'] ? $user['blood_group'] : '&mdash;';
      require 'views/user/profile.php';
    }
    else {
      // 404 not found
    }
  }
}
?>