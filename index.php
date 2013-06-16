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
  /*if (!$_SESSION['tmp']['password'] && !$_SESSION['sm']) {
    header('location:./');
    exit;
  }*/
  
  include_once 'models/User.php';
  $user = new User;
  
  if ($_POST) {
    $_POST['password'] = $_POST['password'] ? $_POST['password'] :$_SESSION['tmp']['password'];
    $_SESSION['tmp'] = $_POST;
    if ($user->signup($_POST['username'], $_POST['name'], $_SESSION['tmp']['email'], $_SESSION['tmp']['password'], $_POST['phone'], $_POST['blood_type'], $_POST['location'], $_SESSION['ref'])) {
      $_SESSION['status'] = 'Your profile has been created. Welcome to lifebank.';
      header('location:../'.$_POST['username']);
      exit;
    }
    else {
    }
  }
  
  require 'views/user/register.php';
}
else if ($url == 'twitter') {
  include_once 'models/User.php';
  $user = new User;

  require 'lib/twitter/twitterOAuth.php';

  // Generate auth url
  // Create TwitterOAuth object with app key/secret
  $twitter = new TwitterOAuth(TwitterOauthKey, TwitterOauthSecret);

  // Request tokens from twitter
  $args = array('oauth_callback' => TwitterCallback);
  $tok = $twitter->getRequestToken($args);

  // Save tokens for later
  $_SESSION['twitter_oauth_request_token'] = $token = $tok['oauth_token'];
  $_SESSION['twitter_oauth_request_token_secret'] = $tok['oauth_token_secret'];

  // Build the authorization URL
  $request_link = $twitter->getAuthorizeURL($token, true);
  header("location:$request_link");
  exit;  
}
else if ($url == 'facebook') {
  include_once 'models/User.php';
  $user = new User;

  require 'lib/facebook/facebook.php';
  
  $facebook = new Facebook(array(
    'appId'  => FBAppID,
    'secret' => FBAppSecret,
  ));
  $user = $facebook->getUser();
  if ($user) {
    if (is_logged()) {
      // add account
    }
    else {
      // social login?
      // no
      // register
    }
  }
  header("location:".$facebook->getLoginUrl());
  exit;  
}
else if ($url == 'twitter-callback') {
  include_once 'models/User.php';
  $user = new User;
  require 'views/user/twitter_callback.php';
}
else {
  if (empty($url)) {
    // Default page
    include_once 'models/User.php';
    $user = new User;
    
    if ($_GET['ref']) {
      if ($user->get_user($_GET['ref'])) {
        $_SESSION['ref'] = $_GET['ref'];
      }
    }
    
    if ($_POST['email'] && $_POST['password']) {
      if (isset($_POST['signup'])) {
        $_SESSION['tmp'] = array(
            'email' => $_POST['email'],
            'password' => $_POST['password']
          );
        unset($_SESSION['sm']);
        header("location:user/signup");
        exit;
      }
      else if (isset($_POST['signin'])) {
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
      if ($_GET['remove'])
        $userModel->remove_social_account($_GET['remove'], $_GET['type']);
      require 'views/user/profile.php';
    }
    else {
      // 404 not found
    }
  }
}
?>