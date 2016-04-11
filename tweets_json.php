<?php

require 'tmhOAuth.php'; // Get it from: https://github.com/themattharris/tmhOAuth
// Use the data from http://dev.twitter.com/apps to fill out this info
// notice the slight name difference in the last two items)
if ($_GET['stream'] == on) {
$connection = new tmhOAuth(array(
'consumer_key' => 'k5Nnrv3dKqTA2cVSoc6dSJHxu',
'consumer_secret' => '1ZyPbisDjmny2e1wLajZmlvGoTsviliOQ1aVyC98NAOeFpL6nT',
'user_token' => '15232369-1ytNxDL4SlkcRmsIJPVfPBzflfl1jbIiYu21dYMJI', //access token
'user_secret' => 'JxUADmW5ZuGIhmWNkP9XUlUyPxGEb9hMhGZnTKQriCWvT', //access token secret
'host' => 'stream.twitter.com/'
));}
if (!$_GET['stream']) {
$connection = new tmhOAuth(array(
'consumer_key' => 'k5Nnrv3dKqTA2cVSoc6dSJHxu',
'consumer_secret' => '1ZyPbisDjmny2e1wLajZmlvGoTsviliOQ1aVyC98NAOeFpL6nT',
'user_token' => '15232369-1ytNxDL4SlkcRmsIJPVfPBzflfl1jbIiYu21dYMJI', //access token
'user_secret' => 'JxUADmW5ZuGIhmWNkP9XUlUyPxGEb9hMhGZnTKQriCWvT', //access token secret

));}
// set up parameters to pass
$parameters = array();
if ($_GET['count']) {
    $parameters['count'] = strip_tags($_GET['count']);
}
if ($_GET['screen_name']) {
    $parameters['screen_name'] = strip_tags($_GET['screen_name']);
}
if ($_GET['twitter_path']) {
    $twitter_path = $_GET['twitter_path'];
} else {
    $twitter_path = '1.1/statuses/user_timeline.json';
}
if($_GET['stream']==on){
    $twitter_path = '1.1/statuses/filter.json';
}
if($_GET['hash']){
    $twitter_path = '1.1/search/tweets.json?q=';
    $hash = explode(",",$_GET['hash']);
    $hashCount = count($hash);
   
   
       for($i=0;$i<=$hashCount-1;$i++){
           if($hashCount -1 == $i){
                $twitter_path .= "%23".$hash[$i];
           }
           if($hashCount-1 != $i){
                $twitter_path .= "%23".$hash[$i]."+OR+";
           }
       }
   
}
print_r($hash);
echo "<br/> how many in the array ".$hashCount;
  echo "<br/>The Path ".substr($connection->url($twitter_path),0,-5)."<br/>";
//print_r($connection);
//$http_code = $connection->request('GET', $connection->url($twitter_path), $parameters);
if(!$_GET['hash']){
    $http_code = $connection->request('GET', $connection->url($twitter_path), $parameters);
}
if($_GET['hash']){
    $http_code = $connection->request('GET', substr($connection->url($twitter_path),0,-5));
}
if ($http_code === 200) { // if everything's good
    $response = strip_tags($connection->response['response']);
    if ($_GET['callback']) { // if we ask for a jsonp callback function
        echo $_GET['callback'], '(', $response, ');';
    } else {
        echo $response;
    }
} else {
    echo "Error ID: ", $http_code, "<br>\n";
    echo "Error: ", $connection->response['error'], "<br>\n"; 
}

// You may have to download and copy http://curl.haxx.se/ca/cacert.pem