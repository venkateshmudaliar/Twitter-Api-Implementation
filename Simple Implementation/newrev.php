<?php

require_once('twitteroauth.php');
require_once('OAuth.php');
require_once('TwitterAPIExchange.php');

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => "enter your oauth_access_token",
    'oauth_access_token_secret' => "enter your oauth_access_token_secret",
    'consumer_key' => "enter your consumer_key",
    'consumer_secret' => "enter your consumer_secret"
);

// get the url from twitter development
$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';

// explain the purpose of get and post
$requestMethod = 'GET';


//set getfield 
$getfield = '?screen_name=venkymudaliar&count=20';


$twitter = new TwitterAPIExchange($settings);
$twitter->buildOauth($url, $requestMethod)
        ->performRequest();


//COMPLICATED COMPLEX RESPONSE
$twitter = new TwitterAPIExchange($settings);
$response1 = $twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();
echo "$response1";



//SIMPLIFIED RESPONSE
//explian json_decode

$string2 = json_decode($twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest(),$assoc = TRUE);

foreach($string2 as $items)
    {
		//explian objects 
		//get name of objects from twitter documentation OR from the complex response

    	$propicurl=$items['user']['profile_image_url'];
    	echo '<img src='.$propicurl.'></img>';
        echo "Time and Date of Tweet: ".$items['created_at']."<br />";
        echo "Tweet: ". $items['text']."<br />";
        echo "Tweeted by: ". $items['user']['name']."<br />";
        echo "Screen name: ". $items['user']['screen_name']."<br />";
        echo "Followers: ". $items['user']['followers_count']."<br />";
        echo "Friends: ". $items['user']['friends_count']."<br />";
        echo "Listed: ". $items['user']['listed_count']."<br />";
        echo "profile image url:". $items['user']['profile_image_url']."<br />";
        echo "url: ". $items['id_str']."<br />;
        <hr>";
    }




?>