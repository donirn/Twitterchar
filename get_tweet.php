<?php
/**
* post_tweet.php
* Example of posting a tweet with OAuth
* Latest copy of this code: 
* http://140dev.com/twitter-api-programming-tutorials/hello-twitter-oauth-php/
* @author Adam Green <140dev@gmail.com>
* @license GNU Public License
*/


function get_tweet($screen_name,$maxid) {

  // Use Matt Harris' OAuth library to make the connection
  // This lives at: https://github.com/themattharris/tmhOAuth
  require_once('tmhoauth/tmhOAuth.php');
      
  // Set the authorization values
  // In keeping with the OAuth tradition of maximum confusion, 
  // the names of some of these values are different from the Twitter Dev interface
  // user_token is called Access Token on the Dev site
  // user_secret is called Access Token Secret on the Dev site
  // The values here have asterisks to hide the true contents 
  // You need to use the actual values from Twitter
  $connection = new tmhOAuth(array(
    'consumer_key' => 'Ja1jvxeHdoN0ArNutunsJQ',
    'consumer_secret' => 'EV9qV60Y2EqHkxvVPILl9Rs5owaIclOMZ7vU784Yy4',
    'user_token' => '940395468-A6aFewBiv7pS5TXMUexqyMJCNk46qlkcA4PWidw',
    'user_secret' => 'gc9w8lFSkMSNhpBoaEWDPBVBCDaVz3bBFMqoWSbIQAQ',
  )); 
  
  // Make the API call
  $connection->request('GET', 
    $connection->url('1.1/statuses/user_timeline.json'), 
    array(
      'screen_name' => $screen_name,
      'count' => '200',
      'max_id' => $maxid,
      'trim_user' => 'true',
      'include_rts' => 'false'
      ));
  
  return $connection;
}
?>