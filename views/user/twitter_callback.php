<?php
require 'lib/twitter/twitterOAuth.php';
// returning from auth, create tokens and save
if(isset($_REQUEST['oauth_token'])) {
	// Create TwitterOAuth object with app key/secret and token key/secret from default phase
	$twitter = new TwitterOAuth(TwitterOauthKey, TwitterOauthSecret, $_SESSION['twitter_oauth_request_token'], $_SESSION['twitter_oauth_request_token_secret']);

	// Request access tokens from twitter
	$tok = $twitter->getAccessToken($_REQUEST['oauth_verifier']);
  
  function get_twitter_user($tok) {
      $twitter = new TwitterOAuth(TwitterOauthKey, TwitterOauthSecret, $tok['oauth_token'], $tok['oauth_token_secret']);
      $args = array('screen_name' => $tok['screen_name'], 'skip_status' => 1);
      return $twitter->get("http://api.twitter.com/1.1/users/show.json", $args);
  }
  
	// Get timeline
	if($tok['screen_name']) {
    if (is_logged()) {
      // Logged? Add account
      $data = get_twitter_user($tok);
      $data['profile_image_url'] = preg_replace('|_normal\.|i', '.', $data['profile_image_url']);
      if ($user->add_social_account($data['id'], $tok['screen_name'], $data['name'], 't', $tok['oauth_token'], $tok['oauth_token_secret'], $data['profile_image_url'])) {
        // Redirect to profile page
        $_SESSION['status'] = 'Your social account has been added to your profile';
      }
      //echo $_SESSION['error'];
      header('location:'.$_SESSION['user']['username']);
      exit;
    }
    else {
      // Nope? Login or Register
      if ($user->social_login($tok['user_id'], 't', $tok['oauth_token'], $tok['oauth_token_secret'])) {
        // Redirect to profile page
        header('location:'.$_SESSION['user']['username']);
        exit;
      }
      else {
        // register
        $data = get_twitter_user($tok);
        $_SESSION['sm']['twitter'] = $data;
        $_SESSION['sm']['twitter']['screen_name'] = $tok['screen_name'];
        $_SESSION['sm']['twitter']['oauth_token'] = $tok['oauth_token'];
        $_SESSION['sm']['twitter']['oauth_token_secret'] = $tok['oauth_token_secret'];
        $_SESSION['tmp'] = array();
        $_SESSION['tmp']['name'] = $data['name'];
        $_SESSION['tmp']['username'] = $tok['screen_name'];
        
        header('location:user/signup');
        exit;
      }
    }
    
    
    // Remove unecessary sessions
    unset($_SESSION['twitter_oauth_request_token']);
    unset($_SESSION['twitter_oauth_request_token_secret']);
  }
}
else {
	header('location:./');
	exit;
}
?>