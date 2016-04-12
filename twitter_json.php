<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



require_once('TwitterAPIExchange.php');

/** Set access tokens here - see: https://dev.twitter.com/apps/ * */
$settings = array(
    'oauth_access_token' => "15232369-1ytNxDL4SlkcRmsIJPVfPBzflfl1jbIiYu21dYMJI",
    'oauth_access_token_secret' => "JxUADmW5ZuGIhmWNkP9XUlUyPxGEb9hMhGZnTKQriCWvT",
    'consumer_key' => "k5Nnrv3dKqTA2cVSoc6dSJHxu",
    'consumer_secret' => "1ZyPbisDjmny2e1wLajZmlvGoTsviliOQ1aVyC98NAOeFpL6nT"
);

$url = "https://api.twitter.com/1.1/search/tweets.json"; //this is the search URL, but we can change this depending on what we want
//$url = "https://stream.twitter.com/1.1/statuses/filter.json?track=twitter";
$requestMethod = "GET"; //Using the GET method instead of POST
//$getfield = '?count=100&q=%23biz417%2BOR%2B%23417mag'; //VARS to pass to twitter for the data we need.
$getfield = '?count=100&q=%23BIZBSCHOOL%2BOR%2B%23biz417';
//$getfield = '?count=100&q=%23springfieldmo%2BOR%2B%23sgf%2BOR%2B%23branson%2BOR%2B%23417magazine%2BOR%2B%23biz417%2BOR%2B%23springfieldmusic';
//calling our class to get json data from twitter

$twitter = new TwitterAPIExchange($settings);
$string = json_decode($twitter->setGetfield($getfield)
                ->buildOauth($url, $requestMethod)
                ->performRequest(), $assoc = TRUE);
if ($string["errors"][0]["message"] != "") {
    echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>" . $string[errors][0]["message"] . "</em></p>";
    exit();
}



if ($_GET['debug']) {
    echo "<pre>"; //if you set debug=on at the end of the url, it will ouput the json
    print_r($string);
    echo "</pre>";
}

//echo count($string['statuses']);
//$itemCount = count($string['statuses']); // this is the count of how many statuses in the json
$itemCount = count($i);
//echo $itemCount;

if($_GET['number']!='null'){
    $i= $_GET['number'];
}else{
    $i=0;
}
//lets create a popup
//$popUpPercent = rand(1,100);

foreach ($string['statuses'] as $items) {
    //echo "<pre>";
    // print_r($items);
//echo "</pre>";
$i++;
    /* echo "ID of Tweet: ".$items['id']."<br />";
      echo "Time and Date of Tweet: ".$items['created_at']."<br />";
      echo "Tweet: ". $items['text']."<br />";
      echo "Tweeted by: ". $items['user']['name']."<br />";
      echo "Screen name: ". $items['user']['screen_name']."<br />";
      echo "Followers: ". $items['user']['followers_count']."<br />";
      echo "Friends: ". $items['user']['friends_count']."<br />";
      echo "Listed: ". $items['user']['listed_count']."<br /><hr />"; */
    $string = $items['text'];
    $userImg = preg_replace("/_normal/", "", $items['user']['profile_image_url']);
    $string = preg_replace('/(^|\s)#(\w*[a-zA-Z_]+\w*)/', '\1<span class="hashTag">#\2</span>', $string);
    $twitImage = $items['entities']['media'][0]['media_url'];
    //echo $twitImage;

    echo($test);
    echo "<div class='tweetMotherDiv' id='iam".$i."' style='' data-num='".$i."'>
       <div class='tweetDiv' style=''>
         <table>
             <tr>
                 <td valign='top'>
                     <div class='tweetUserImage' style=''><img src='" . $userImg . "' /></div>
                 </td>
                 <td valign='top'>
                     <table>
                         <tr>
                             <td >
                                 <!--<div class='tweetUserName' style=''>" . $items['user']['name'] . "</div>-->
                             
                                 <div class='tweetUserName' style=''>@" . $items['user']['screen_name'] . "</div>
                             </td>
                         </tr>
                         <tr>
                             <td colspan='2'>
                                 <div class='tweetActual' style=''>" . $string . "</div><br/>
                                     <div class='tweetActualImage'>";
    if($twitImage != ""){echo "<img src='".$twitImage."'  />";}
    echo "<div>
                             </td>
                         </tr>
                     </table>
                 </td>
             </tr>
         </table>
        </div>
        </div>
    ";
}
//moved this to index and javascript
//this is the percentage
/*if($popUpPercent <= 25){
    //the number in the if, is basically how often a pop up might occure. in percentage
    $popUpDiv = rand(1,$itemCount);
   // echo $popUpDiv;
    
    echo "<script>";
    echo "koPopUp('iam".$popUpDiv."','no')";
    echo "</script>";
}*/
/*
 * Could set up a settings database to set how oftin the pop up happens and the auto scroll settings.. maybe other cool stuff in the future
 * from an admin panel?
 */
    
    