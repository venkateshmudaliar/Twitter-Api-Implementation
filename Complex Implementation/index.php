<?php
//start session
//  initiate a session on each PHP page. It must be the first thing sent to the browser, 
//or it won't work properly, so it's usually best to place it right after the <?php tags.

session_start();

//just simple session reset on logout click


// Include config file and twitter PHP Library by Abraham Williams (abraham@abrah.am)
include_once("include/config.php");
include_once("include/twitteroauth.php");
require_once('include/TwitterAPIExchange.php');
?>


<html>
<head>
<title>Twitter Api</title>
<style type="text/css">

/*

YOU DONE NEED CSS INITIALLY 
CAN ADD IT LATER


.wrapper{width:600px; margin-left:auto;margin-right:auto;}
.welcome_txt{
	margin: 20px;
	background-color: #EBEBEB;
	padding: 10px;
	border: #D6D6D6 solid 1px;
	-moz-border-radius:5px;
	-webkit-border-radius:5px;
	border-radius:5px;
}
.tweet_box{
	margin: 20px;
	background-color: #FFF0DD;
	padding: 10px;
	border: #F7CFCF solid 1px;
	-moz-border-radius:5px;
	-webkit-border-radius:5px;
	border-radius:5px;
}
.tweet_box textarea{
	width: 500px;
	border: #F7CFCF solid 1px;
	-moz-border-radius:5px;
	-webkit-border-radius:5px;
	border-radius:5px;
}
.tweet_list{
	margin: 20px;
	padding:20px;
	background-color: #E2FFF9;
	border: #CBECCE solid 1px;
	-moz-border-radius:5px;
	-webkit-border-radius:5px;
	border-radius:5px;
}
.tweet_list ul{
	padding: 0px;
	font-family: verdana;
	font-size: 12px;
	color: #5C5C5C;
}
.tweet_list li{
	border-bottom: silver dashed 1px;
	list-style: none;
	padding: 5px;
}

#bannerpic
{
	width: 100%;
	height: 80%;
}

*/
</style>
</head>
<body>
<!-- BETTER TO CREATE A DIV -->
<div class="wrapper">


<?php

//$_SESSION is global variable

if(isset($_SESSION['status']) && $_SESSION['status']=='verified') 
{	
	//SESSION IS VERFIED IN PROCESS.php AND RETURNS WITH VERIFIED STATUS
	//AND ITS redirected back from process.php with varified status.
	

	//retrive variables

	$screenname 		= $_SESSION['request_vars']['screen_name'];
	$twitterid 			= $_SESSION['request_vars']['user_id'];
	$oauth_token 		= $_SESSION['request_vars']['oauth_token'];
	$oauth_token_secret = $_SESSION['request_vars']['oauth_token_secret'];

	

	//TOKENS

	$settings = array(
    'oauth_access_token' => "enter your oauth_access_token",
    'oauth_access_token_secret' => "enter your oauth_access_token_secret",
    'consumer_key' => "enter your consumer_key",
    'consumer_secret' => "enter your consumer_secret"
    );



	//SHOW ALL URLS IN TWITTER DOCUMENTATION

	$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
	$usershow = "https://api.twitter.com/1.1/users/show.json";
	$mentions= "https://api.twitter.com/1.1/statuses/mentions_timeline.json";
	$hometimeline="https://api.twitter.com/1.1/statuses/home_timeline.json";
	$posttweet="https://api.twitter.com/1.1/statuses/update.json";
	$mediaupdate="https://api.twitter.com/1.1/statuses/update_with_media.json";
	$followersid= "https://api.twitter.com/1.1/followers/ids.json";
	$friendslist= "https://api.twitter.com/1.1/friends/list.json";
	$followerslist= "https://api.twitter.com/1.1/followers/list.json";
	$usersearch= "https://api.twitter.com/1.1/users/search.json";
	$profilebanner= "https://api.twitter.com/1.1/users/profile_banner.json";
	$tweetoembed= "https://publish.twitter.com/oembed";

	//SETTING THE POST AND GET METHOD VARIABLES
	$requestMethod = "GET";
	$postMethod="POST";

	//SETTING GET FIELD
	$getfield = '?screen_name='.$screenname.'&count=10';

	/*users statuses*/
	$twitter = new TwitterAPIExchange($settings);
 	$twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();

	$string = json_decode($twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest(),$assoc = TRUE);

	/*for profile pic*/
	$twitter = new TwitterAPIExchange($settings);
 	$twitter->setGetfield($getfield)
             ->buildOauth($usershow, $requestMethod)
             ->performRequest();

    $usershowstring = json_decode($twitter->setGetfield($getfield)
             ->buildOauth($usershow, $requestMethod)
             ->performRequest(),$assoc = TRUE);


    /*show mentions*/
    $twitter = new TwitterAPIExchange($settings);
 	$twitter->setGetfield($getfield)
             ->buildOauth($mentions, $requestMethod)
             ->performRequest();

	$mentions_string = json_decode($twitter->setGetfield($getfield)
             ->buildOauth($mentions, $requestMethod)
             ->performRequest(),$assoc = TRUE);

	/*home timeline*/
	$twitter = new TwitterAPIExchange($settings);
 	$twitter->setGetfield($getfield)
             ->buildOauth($hometimeline, $requestMethod)
             ->performRequest();

	$hometimeline_string = json_decode($twitter->setGetfield($getfield)
             ->buildOauth($hometimeline, $requestMethod)
             ->performRequest(),$assoc = TRUE);

	
	/*post tweet*/
	$statusval=$_POST["updateme"];
	
	$setPostfields= array('status' => $statusval );
	$twitter = new TwitterAPIExchange($settings);
 	$twitter->setPostfields($setPostfields)
             ->buildOauth($posttweet, $postMethod)
             ->performRequest();

	$posttweet_string = json_decode($twitter->setPostfields($setPostfields)
             ->buildOauth($posttweet, $postMethod)
             ->performRequest(),$assoc = TRUE);

	/*get list of followers id*/
	$getfollowersid = '?screen_name='.$screenname;
	$twitter = new TwitterAPIExchange($settings);
 	$twitter->setGetfield($getfollowersid)
             ->buildOauth($followersid, $requestMethod)
             ->performRequest();

	$followersid_string = json_decode($twitter->setGetfield($getfollowersid)
             ->buildOauth($followersid, $requestMethod)
             ->performRequest(),$assoc = TRUE);

	/* get list of frriends*/
	$getfriendslist = '?screen_name='.$screenname;
	
	$twitter = new TwitterAPIExchange($settings);
 	$twitter->setGetfield($getfriendslist)
             ->buildOauth($friendslist, $requestMethod)
             ->performRequest();

	$friendslist_string = json_decode($twitter->setGetfield($getfriendslist)
             ->buildOauth($friendslist, $requestMethod)
             ->performRequest(),$assoc = TRUE);

	/* get list of followers */
	$getfollowers = '?screen_name='.$screenname.'&count=10';

	$twitter = new TwitterAPIExchange($settings);
 	$twitter->setGetfield($getfollowers)
             ->buildOauth($followerslist, $requestMethod)
             ->performRequest();

	$followerslist_string = json_decode($twitter->setGetfield($getfollowers)
             ->buildOauth($followerslist, $requestMethod)
             ->performRequest(),$assoc = TRUE);

	/*user search*/
	$searchquery=$_POST["usersearch"];
	$getsearchuser = '?screen_name='.$screenname.'&q='.$searchquery;

	$twitter = new TwitterAPIExchange($settings);
 	$twitter->setGetfield($getsearchuser)
             ->buildOauth($usersearch, $requestMethod)
             ->performRequest();

	$searchuser_string = json_decode($twitter->setGetfield($getsearchuser)
             ->buildOauth($usersearch, $requestMethod)
             ->performRequest(),$assoc = TRUE);

	/*get profile banner*/
	$getprofilebanner = '?screen_name='.$screenname;

	$twitter = new TwitterAPIExchange($settings);
 	$twitter->setGetfield($getprofilebanner)
             ->buildOauth($profilebanner, $requestMethod)
             ->performRequest();

	$profilebanner_string = json_decode($twitter->setGetfield($getprofilebanner)
             ->buildOauth($profilebanner, $requestMethod)
             ->performRequest(),$assoc = TRUE);

	
	
	
	$bannerpicurl=$profilebanner_string['sizes']['1500x500']['url'];
	
	$picurl=$usershowstring['profile_image_url'];
	
	print_r("banner pic url:".$bannerpicurl);
	echo "<hr>";
	//echo '<img id="bannerpic" src='.$bannerpicurl.'></img><hr>';


	echo "<hr>";
	echo '<img src='.$picurl.'></img><hr>';
	echo '<div class="welcome_txt">Welcome <strong>'.$screenname;

	// TWEET BOX
	echo '<div class="tweet_box">';
	echo '<form id="tweetform" method="post" action="index.php"><table width="200" border="0" cellpadding="3">';
	echo '<table width="200" border="0" cellpadding="3">';
	echo '<tr>';
	echo '<td><textarea name="updateme" id="textupdate" cols="60" rows="4"></textarea></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><input type="submit" value="Tweet" name="submit" onClick="clearform();"/></td>';
	echo '</tr></table></form>';
	echo '</div>';


	echo "<hr>";

	//PROVIDING LOGOUT BUTTOn
	echo  '<br><a href="logout.php">Logout</a></div>';

	//USER INFORMATION
	
	echo "<hr><h2>elements from usershow ie information about user</h2><br>";
	echo "<br>Name: ".$usershowstring['screen_name'];
	echo "<br>Location: ".$usershowstring['location'];
	echo "<br>Info: ".$usershowstring['description'];
	echo "<br>Followers: ".$usershowstring['followers_count'];
	echo "<br>Following: ".$usershowstring['friends_count'];
	echo "<br>Tweets: ".$usershowstring['statuses_count'];
	echo "<hr>";

	
	/* LIST OF MENTIONS	
	echo "<hr><h2>List of mentions</h2><br>";
	print_r($mentions_string);
	echo "<hr>";
	*/

	echo "<h2>User Timeline tweets</h2><br>";
	foreach($string as $items)
    {
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
/*
    //HOME TIMELINE DISPLAY
    echo "<hr><h2>Home Timeline</h2><br>";
	print_r($mentions_string);
	echo "<hr>";

	
	

	echo "<hr><h2>Update tweet/post tweet</h2><br>";
	echo '<div class="tweet_box">';
	echo '<form id="tweetform" method="post" action="index.php"><table width="200" border="0" cellpadding="3">';
	echo '<table width="200" border="0" cellpadding="3">';
	echo '<tr>';
	echo '<td><textarea name="updateme" id="textupdate" cols="60" rows="4"></textarea></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><input type="submit" value="Tweet" name="submit" onClick="clearform();"/></td>';
	echo '</tr></table></form>';
	echo '</div>';

	/* 

	LIST OF FOLLOWERS
	echo "<hr><h2>List of Followers Ids</h2><br>";
	print_r($followersid_string);
	echo "<hr>";
	
	LIST OF FRIENDS
	echo "<hr><h2>List of Friends</h2><br>";
	print_r($friendslist_string);
	echo "<hr>";

	echo "<hr><h2>List of Followers</h2><br>";
	print_r($followerslist_string);
	echo "<hr>";

	echo "<hr><h2>Search user</h2><br>";
	echo '<div class="tweet_box">';
	echo '<form  method="post" action="index.php"><table width="200" border="0" cellpadding="3">';
	echo '<table width="200" border="0" cellpadding="3">';
	echo '<tr>';
	echo '<td><input type="text" name="usersearch" ></textarea></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><input type="submit" value="search" name="submit" onClick="clearform();"/></td>';
	echo '</tr></table></form>';
	echo '</div>';
	print_r($searchuser_string);
	echo "<hr>";
	
	*/
	/*
	echo "<hr><h2>Profile Banner Image </h2><br>";
	print_r($profilebanner_string);
	echo "<hr>";
*/




	
	


	
		
}
else
{
	//login button
	echo '<a href="process.php"><img src="images/sign-in-with-twitter-l.png" width="151" height="24" border="0" /></a>';
}

?>
</div>
</body>
<script type="text/javascript">
d
	function clearform()
{

}
</script>
</html>
