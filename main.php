<?php
include 'facebook.php';
$app_id = "194472553967386";
$app_secret = "c1c717bae764f6942cab276638886fd0";
$facebook = new Facebook(array(
    'appId' => $app_id,
    'secret' => $app_secret,
    'cookie' => true
));

$user = $facebook->getUser();


if ($user <> '0' && $user <> '') 
{ 
    $user_profile = $facebook->api('/me');
	$fbname = $user_profile['name'];
}
else
{
	$loginUrl = $facebook->getLoginUrl();
	header('Location: ' . $loginUrl);
}

$host="stevenswallcom.ipagemysql.com"; // Host name
$username="socialqs"; // Mysql username
$password="323232"; // Mysql password
$db_name="socialqs_db"; // Database name
$tbl_name="socialqs_question"; // Table name

// Connect to server and select databse.
mysql_connect("$host", "$username", "$password")or die("cannot connect");
mysql_select_db("$db_name")or die("cannot select DB");

$sqla="SELECT * FROM $tbl_name ORDER BY id DESC LIMIT 10";
// OREDER BY datetime DESC is order result by descending
$result=mysql_query($sqla);






?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
  xmlns:fb="https://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <title>Social Knowledge Homepage</title>
</head>



    <body>
	<div id="fb-root"></div>
	<script src="http://connect.facebook.net/en_US/all.js"></script>
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '194472553967386',
          channelUrl : 'http://www.stevenswall.com/fbtest/channel.html', // Channel File
          status     : true,
          cookie     : true,
          xfbml      : true
        });


      FB.getLoginStatus(function(response) {
	  		    if (response.status === 'connected') {
	  		      var uid = response.authResponse.userID;
	  		      var accessToken = response.authResponse.accessToken;

	  		    } else if (response.status === 'not_authorized') {
	  		      // the user is logged in to Facebook,
	  		      //but not connected to the app
	  		      window.location = "http://apps.facebook.com/socialqs";
	  		    } else {
	  		      window.location = "http://stevenswall.com/fbtest/index.php";
	  		    }
 });



      <script>(function(d){
         var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
         js = d.createElement('script'); js.id = id; js.async = true;
         js.src = "//connect.facebook.net/en_US/all.js";
         d.getElementsByTagName('head')[0].appendChild(js);
       }(document));</script>


<link rel="stylesheet" type="text/css" media="all" href="tables.css" />
<link rel="stylesheet" type="text/css" media="all" href="center.css" />
<link rel="stylesheet" href="form.css" type="text/css" media="all" />
<form class="form" action="add_question.php" method="post">

<p class="question">
<input type="text" name="question" id="question" style="width:790px; height:100px; font-size:35"/>
<label for="question">Question</label>
</p>

<p class="submit" align="left">
<input type="submit" value="Ask" style="height: 50px; width: 250px; font-size:32"/>
</p>
</form>


<center>
<table id="rounded-corner">
<thead>

<tr>
<th scope="col" class="rounded-company" colspan="7"><strong><p class="table">RECENTLY ASKED QUESTIONS (TOP 10)</p></strong></th>
<th scope="col" class="rounded-q4"></th>
</tr>

<tr>
<th scope="col" class="rounded-q1" align="center"><strong>User</strong></th>
<th scope="col" class="rounded-q2" align="left"><strong>Name</strong></th>
<th scope="col" class="rounded-q3" align="left"><strong>Question</strong></th>
<th scope="col" class="rounded-q1" align="center"><strong>Views</strong></th>
<th scope="col" class="rounded-q2" align="center"><strong>Replies</strong></th>
<th scope="col" class="rounded-q2" align="center"><strong>Likes</strong></th>
<th scope="col" class="rounded-q2" align="center"><strong>Shares</strong></th>
<th scope="col" class="rounded-q3" align="center"><strong>Date/Time</strong></th>
</tr>
</thead>

<?php


while($rows = mysql_fetch_array($result))
{ 
// Start looping table row


?>

<tbody>
<tr>
<td align="center"><a target="_blank" href="http://www.facebook.com/<? echo $rows['fbid']; ?>"><img src="https://graph.facebook.com/<? echo $rows['fbid']; ?>/picture"></a></td>
<td><? echo $rows['name']; ?></td>
<td><a href="view_question.php?id=<? echo $rows['id']; ?>"><? echo $rows['question']; ?></a></td>
<td align="center"><? echo $rows['view']; ?></td>
<td align="center"><? echo $rows['replies']; ?></td>
<td align="center"><? echo $rows['likes']; ?></td>
<td align="center"><? echo $rows['shares']; ?></td>
<td align="center"><? echo $rows['datetime']; ?></td>
</tr>

<?php
// Exit looping and close connection
}
mysql_close();
?>
<tfoot>

    	<tr>

        	<td colspan="7" class="rounded-foot-left"><em><a href="all_questions.php"><strong>View All Questions</strong> </a></em></td>

        	<td class="rounded-foot-right">&nbsp;</td>

        </tr>

    </tfoot>


</tbody>
</table>
</center>
</html>