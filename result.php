<?php

require_once('get_tweet.php');
set_time_limit(60);

// get input from user
$screen_name = $_POST['screen_name'];

// variable helper
$tweetIndex = 1;
$max_id = '999999999999999999';
$outOfYear2014 = false;

do {
  // http request
  $result = get_tweet($screen_name, $max_id);
  $codeResponse = $result->response['code'];
  $rawResponse = $result->response['raw'];

  // parse json
  $tweetsJSON = substr($rawResponse,strpos($rawResponse,'['));
  $tweets = json_decode($tweetsJSON);

  // to keep track of numberOfTweet retrieved
  $numberOfTweet = 0;

  // loop for each tweet retrieved
  foreach($tweets as $tweet)
  {
    // get data from $tweet
    if($tweet->id_str == $max_id)continue;
    $text = $tweet->text;
    $timestamp = $tweet->created_at;
    $year = substr($timestamp, -4);
    $month = substr($timestamp,4,3);
    $tweet_id = $tweet->id_str;
    $chars = strlen($text);

    // check if year is not 2014
    if($year<2014){
      $outOfYear2014 = true;
      break;
    }
    else if($year>2014)
      continue;

    // add text length to its month cumulative
    $charsMonth["$month $year"] += $chars;

    // print tweet data and increment $tweetIndex
    // print("$tweetIndex. $text | $month $year | $chars <br>");
    $tweetIndex++;

    // replace max_id if tweet_id is lower
    if ($tweet->id_str < $max_id)
      $max_id = $tweet->id_str;

    // increment number of tweet retrieved
    $numberOfTweet++;
  }
  // print("<br>MAX ID : $max_id<br><br>");

} while ($codeResponse == 200 && $numberOfTweet > 1 && !$outOfYear2014);

foreach ($charsMonth as $key => $value) {
  print("$key: $value<br>");
  $totalChars += $value;
}
print("-----------------------------<br>");
print("<b>Total: $totalChars</b>");
?>