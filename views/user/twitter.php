<?php
// @kehers
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
?>