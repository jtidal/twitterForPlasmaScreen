<?php

require_once('twitter-api-php-master/TwitterAPIExchange.php');

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => "",
    'oauth_access_token_secret' => "",
    'consumer_key' => "",
    'consumer_secret' => ""
);

$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";

$requestMethod = "GET";

$getfield = '?screen_name=CityTechLibrary&count=1'; //Insert Twitter handle here


echo "<h1>Latest Tweet</h1>";

$twitter = new TwitterAPIExchange($settings);
$string = json_decode($twitter->setGetfield($getfield)
->buildOauth($url, $requestMethod)
->performRequest(),$assoc = TRUE);
if($string["errors"][0]["message"] != "") {echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";exit();}


function twitter_time($a) {
    //get current timestampt
    $b = strtotime("now"); 
    //get timestamp when tweet created
    $c = strtotime($a);
    //get difference
    $d = $b - $c;
    //calculate different time values
    $minute = 60;
    $hour = $minute * 60;
    $day = $hour * 24;
    $week = $day * 7;
        
    if(is_numeric($d) && $d > 0) {
        //if less then 3 seconds
        if($d < 3) return "right now";
        //if less then minute
        if($d < $minute) return floor($d) . " seconds ago";
        //if less then 2 minutes
        if($d < $minute * 2) return "about 1 minute ago";
        //if less then hour
        if($d < $hour) return floor($d / $minute) . " minutes ago";
        //if less then 2 hours
        if($d < $hour * 2) return "about 1 hour ago";
        //if less then day
        if($d < $day) return floor($d / $hour) . " hours ago";
        //if more then day, but less then 2 days
        if($d > $day && $d < $day * 2) return "yesterday";
        //if less then year
        if($d < $day * 365) return floor($d / $day) . " days ago";
        //else return more than a year
        return "over a year ago";
    }
}



echo '
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Single Tweet</title>

    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">

<link href="//maxcdn.bootstrapcdn.com/bootswatch/3.2.0/readable/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="cover.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body background="http://www.wallsk.com/wp-content/uploads/2014/06/new-york-city-twitter-backgrounds-8.jpg">

    <div class="site-wrapper">


        <div class="cover-container">



          <div class="inner cover" style="padding-top:100px">
            <h1 class="cover-heading">

            <div class="panel panel-primary" >
            <div class="panel-heading" style="text-align:left;">@CityTechLibrary<br><h4>CityTechLibrary</h4></div>
  <div class="panel-body">';

            
foreach($string as $items)
    {
        echo   $items["text"].'<br />';
        echo  '<div class="panel-footer" style="text-align:right"><h4>'.twitter_time($items["created_at"]).'</h4></div>';

    }          

         echo '</h1></div></div></div><div class="mastfoot">

          </div>

        </div>


    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="../../assets/js/docs.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
';

?>
